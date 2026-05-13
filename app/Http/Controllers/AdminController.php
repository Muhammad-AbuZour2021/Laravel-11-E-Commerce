<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Slide;
use App\Models\User;
use Faker\Core\File;
use Faker\Provider\File as ProviderFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // <--- هذا هو السطر الناقص الذي يسبب الخطأ
class AdminController extends Controller
{
    public function index()
    {

        $orders = Order::orderBy('created_at', 'DESC')->get()->take(10);

        $dashboardDatas = DB::select("SELECT
    SUM(total) AS TotalAmount,
    SUM(IF(status='ordered', total, 0)) AS TotalOrderedAmount,
    SUM(IF(status='delivered', total, 0)) AS TotalDeliveredAmount,
    SUM(IF(status='cancelled', total, 0)) AS TotalCanceledAmount,
    COUNT(*) AS Total,
    SUM(IF(status='ordered', 1, 0)) AS TotalOrdered,
    SUM(IF(status='delivered', 1, 0)) AS TotalDelivered,
    SUM(IF(status='cancelled', 1, 0)) AS TotalCanceled
FROM Orders;");
        return view('admin.index', compact('orders', 'dashboardDatas'));
    }

    public function slides()
    {
        $slides = Slide::orderBy('id', 'DESC')->paginate(12);
        return view('admin.slides', compact('slides'));

    }

    public function slides_add()
    {
        return view('admin.slides-add');

    }
    public function slides_store(Request $request)
    {
        $request->validate([

            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'link' => 'required',
            'status' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'

        ]);

        $slide = new Slide();
        $slide->tagline = $request->tagline;
        $slide->titel = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;
        if ($image = $request->file('image')) {

            $destinationPath = 'uploads/slides/';
            $file_Image = date('ymdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $file_Image);
            $slide->image = $file_Image;
        }
        $slide->save();



        return redirect()->route('admin.slides')->with("status", "Slide added successfully!");
    }
    public function slides_edit($id)
    {
        $slide = Slide::find($id);
        return view('admin.slides-edit', compact('slide'));
    }
    public function slides_update(Request $request)
    {
        $request->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'link' => 'required',
            'status' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        $slide = Slide::find($request->id);

        if (!$slide) {
            return redirect()->back()->with('error', 'Slide not found');
        }

        $slide->tagline = $request->tagline;
        $slide->titel = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;

        // تحديث الصورة (إذا تم رفع صورة جديدة)
        if ($request->hasFile('image')) {

            // حذف الصورة القديمة
            if ($slide->image && file_exists(public_path('uploads/slides/' . $slide->image))) {
                unlink(public_path('uploads/slides/' . $slide->image));
            }

            // رفع الصورة الجديدة
            $image = $request->file('image');
            $file_Image = date('ymdHis') . "." . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/slides'), $file_Image);

            $slide->image = $file_Image;
        }

        $slide->save();

        return redirect()->route('admin.slides')->with("status", "Slide updated successfully!");
    }
    public function slides_delete($id)
    {
        $slide = Slide::find($id);

        // إذا السلايد غير موجود
        if (!$slide) {
            return redirect()->route('admin.slides')
                ->with("error", "Slide not found!");
        }

        // حذف الصورة إذا موجودة
        $imagePath = public_path('uploads/slides/' . $slide->image);

        if ($slide->image && file_exists($imagePath)) {
            unlink($imagePath);
        }

        // حذف السجل من قاعدة البيانات
        $slide->delete();

        return redirect()->route('admin.slides')
            ->with("status", "Slide deleted successfully!");
    }

    public function user()
    {
        $users = User::where('utype', 'USR')->paginate(10);
        return view('admin.user', compact('users'));
    }
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user-edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'utype' => 'required|in:USR,ADM',
        'password' => 'nullable|min:6|confirmed'
    ]);

    $user = User::findOrFail($id);

    $user->name = $request->name;
    $user->utype = $request->utype;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('admin.users')
        ->with('status', 'User updated successfully!');
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users')->with('status', 'User deleted successfully!');
    }
}

