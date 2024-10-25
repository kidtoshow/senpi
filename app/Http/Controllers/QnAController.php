<?php

namespace App\Http\Controllers;

use App\QnaAttachment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use App\QnA;
use App\User;
use App\QACategory;
use App\QACategoryRelation;
use App\CollectQA;


class QnAController extends Controller
{
    public function list()
    {
        $uid = Auth::user()->id;
        $QnA = QnA::where('uid', $uid)->orderBy('id','desc')->get();
        $QACategory = new QACategory;
        $QACategoryRelation = new QACategoryRelation;
        $Data = [
            'QandA' => $QnA,
            'QACategory' => $QACategory,
            'QACategoryRelation' => $QACategoryRelation
        ];

        return view('qa.list')->with('Data', $Data);
    }

    public function create()
    {
        $categories = QACategory::all();
        $Data = [
            'authId' => Auth()->user()->id,
            'categories' => $categories
        ];
        return view('qa.create')->with('Data', $Data);
    }

    public function save(Request $req)
    {
        $req->validate([
            'attachment.*' => 'file|max:2000|nullable',
            "amount_up" => "integer|max:999999999|min:0",
            "amount_down" => "integer|max:999999999|min:0",
            "category" => "required|array|max:3|min:1",
            'nickname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:255',
            'line' => 'nullable|string|max:255',
            'contact_time' => 'required|string|max:255',
            'contact_time_end' => 'required|string|max:255',
            'place' => 'string|max:255',
            'qabody' => 'required|string|max:2000',

        ],[
            'attachment.*.max' => "上傳檔案不得超過2M",
            "amount_up.min" => "上限值不得低於:min",
            "amount_up.max" => "上限值不得高於:max",
            "amount_up.integer" => "金額必須為數字",
            "amount_down.integer" => "金額必須為數字",
            "amount_down.min" => "下限值不得低於:min",
            "amount_down.max" => "下限值不得高於:max",
            "category.max" => "主題不得超過:max個",
            "category.min" => "主題不得低於:min個",
            "nickname.required" => "暱稱必須填寫",
            'nickname.max' => "暱稱不得超過:max字",
            "email.email" => "email格式不正確",
            "email.max" => "email不得超過:max",
            "contact_time.required" => "聯絡時間必須填寫",
            "contact_time_end.required" => "聯絡時間必須填寫",
            'qabody.required' => "內文必須填寫",
            'place.string' => "地點必須為文字",
            'phone.required' => '聯絡電話必須填寫',
            'category.required' => '問題類別必須選擇'
        ]);


        $QnA = new QnA();
        $QnA->uuid = 'qa-'.uniqid();
        $QnA->nickname = $req->nickname;
        $QnA->email = $req->email;
        $QnA->title = $req->title;
        $QnA->phone = $req->phone;
        $QnA->line = $req->line;
        $QnA->place = $req->place;
        $QnA->uid = $req->author;
//        $QnA->state = $req->state;
        $QnA->body = $req->qabody;
        $QnA->contact_time = $req->contact_time;
        $QnA->contact_time_end = $req->contact_time_end;
        $QnA->amount_up = $req->amount_up;
        $QnA->amount_down = $req->amount_down;
        $QnA->save();

        $category = $req->category;
        if(isset($category)) 
        {
            $qaId = $QnA->id;
            if($category!='') {
                foreach ($category as $cId)
                {                   
                    $qaCategoryRelation = new QACategoryRelation();
                    $qaCategoryRelation->category_id = $cId;
                    $qaCategoryRelation->qa_id = $qaId;
                    $qaCategoryRelation->save();
                }
            }
        }

        if($req->file('attachments')){
            foreach($req->attachments as $attachment) {
                $fileName = time().'-'.$attachment->getClientOriginalName();
                $attachment->storeAs('qa_attachment', $fileName, 'admin');
                QnaAttachment::create([
                    'qa_id' => $QnA->id,
                    'file_path' => '/qa_attachment/'.$fileName,
                    'file_name' => $attachment->getClientOriginalName()
                ]);
            }
        }

        return redirect()->route('list-all-qa');
    }

    public function edit($uuid)
    {
        $uid = Auth::user()->id;
        $QnA = QnA::where('uuid', $uuid)->first();
        $categories = QACategory::all();
        $qaCategoryRelation = QACategoryRelation::where('qa_id', $QnA->id)->get();
        $selectCategories = [];
        foreach($qaCategoryRelation as $ele) {
            array_push($selectCategories, $ele->category_id);
        }

        $Data = [
            'qa' => $QnA,
            'authId' => Auth()->user()->id,
            'categories' => $categories,
            'selectCategories' => $selectCategories
        ];
        return view('qa.edit')->with('Data', $Data);
    }

    public function update(Request $req) 
    {
        $req->validate([
            'attachment.*' => 'file|max:2000|nullable',
            "amount_up" => "integer|max:999999999|min:0",
            "amount_down" => "integer|max:999999999|min:0",
            "category" => "rquired|array|max:3|min:1",
            'nickname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:255',
            'line' => 'nullable|string|max:255',
            'contact_time' => 'required|string|max:255',
            'contact_time_end' => 'required|string|max:255',
            'place' => 'string|max:255',
            'qabody' => 'required|string|max:2000',

        ],[
            'attachment.*.max' => "上傳檔案不得超過2M",
            "amount_up.min" => "上限值不得低於:min",
            "amount_up.max" => "上限值不得高於:max",
            "amount_up.integer" => "金額必須為數字",
            "amount_down.integer" => "金額必須為數字",
            "amount_down.min" => "下限值不得低於:min",
            "amount_down.max" => "下限值不得高於:max",
            "category.max" => "主題不得超過:max個",
            "category.min" => "主題不得低於:min個",
            "nickname.required" => "暱稱必須填寫",
            'nickname.max' => "暱稱不得超過:max字",
            "email.required" => "email必須填寫",
            "email.email" => "email格式不正確",
            "email.max" => "email不得超過:max",
            "contact_time.required" => "聯絡時間必須填寫",
            "contact_time_end.required" => "聯絡時間必須填寫",
            'qabody.required' => "內文必須填寫",
            'place.string' => "地點必須為文字",
//            'line.required' => 'LINE必須填寫',
//            'phone.required' => '聯絡電話必須填寫'
        ]);

        $QnA = QnA::where('uuid', $req->uuid)->first();
        $QnA->nickname = $req->nickname;
        $QnA->title = $req->title;
        $QnA->uid = $req->author;
//        $QnA->state = $req->state;
        $QnA->body = $req->qabody;
        $QnA->phone = $req->phone;
        $QnA->line = $req->line;
        $QnA->email =$req->email;
        $QnA->place = $req->place;
        $QnA->contact_time = Carbon::parse($req->contact_time)->format('Y-m-d H:i:s');
        $QnA->contact_time_end = Carbon::parse($req->contact_time_end)->format('Y-m-d H:i:s');

        $category = $req->category;
        if(isset($category)) 
        {
            $qaId = $QnA->id;
            if($category!='') {
                $qaCategory = QACategoryRelation::where('qa_id', $qaId)->delete();
                foreach ($category as $cId)
                {                   
                    $qaCategoryRelation = new QACategoryRelation();
                    $qaCategoryRelation->category_id = $cId;
                    $qaCategoryRelation->qa_id = $qaId;
                    $qaCategoryRelation->save();
                }
            }
        }

        $QnA->save();

        if($req->file('attachments')){
            foreach($req->attachments as $attachment) {
                $fileName = time().'-'.$attachment->getClientOriginalName();
                $attachment->storeAs('qa_attachment', $fileName, 'admin');
                QnaAttachment::create([
                    'qa_id' => $QnA->id,
                    'file_path' => '/qa_attachment/'.$fileName,
                    'file_name' => $attachment->getClientOriginalName()
                ]);
            }
        }

        return redirect()->route('list-all-qa');
    }

    public function delete($uuid) 
    {
        $QnA = QnA::where('uuid', $uuid)->first();
        QACategoryRelation::where('qa_id', $QnA->id)->delete();
        CollectQA::where('qa_id', $QnA->id)->delete();
        $QnA->attachments->each(function($item){
           if(file_exists(public_path('uploads'.$item->file_path))){
               unlink(public_path('uploads'.$item->file_path));
           }
           $item->delete();
        });
        $QnA->delete();

        return back();
    }

    public function deleteCollectQa($uuid)
    {

        $QnA = QnA::where('uuid', $uuid)->first();
        CollectQA::where('qa_id', $QnA->id)->where('uid', auth()->user()->id)->delete();

        return back();
    }

    public function collect()
    {
        $uid = Auth::user()->id;
        $collect = CollectQA::where('uid', $uid)->get();
        $QACategory = new QACategory;
        $QACategoryRelation = new QACategoryRelation;
        
        $qaList = [];
        foreach($collect as $ele) {
            $qa = QnA::where('id', $ele->qa_id)->first();
            array_push($qaList, $qa);
        }

        $Data = [
            'QandA' => $qaList,
            'QACategory' => $QACategory,
            'QACategoryRelation' => $QACategoryRelation
        ];

        return view('qa.collect')->with('Data', $Data);
    }

    public function show($slug)
    {
        $uid = Auth::user()->id;
        $QnA = QnA::where('uuid', $slug)->first();
        $categories = QACategory::all();
        $qaCategoryRelation = QACategoryRelation::where('qa_id', $QnA->id)->get();
        $selectCategories = [];
        foreach($qaCategoryRelation as $ele) {
            array_push($selectCategories, $ele->category_id);
        }

        $Data = [
            'qa' => $QnA,
            'authId' => Auth()->user()->id,
            'categories' => $categories,
            'selectCategories' => $selectCategories
        ];

        return view('qa.view')->with('Data', $Data);
    }

    public function showCollectQa($uuid)
    {
        $uid = Auth::user()->id;
        $qna = QnA::where('uuid', $uuid)->first();

        return view('qa.view_collect_qa', compact(['qna']));
    }

    public function deleteAttachment($id)
    {
        $attachment = QnaAttachment::find($id);
        if(is_null($attachment))
        {
            return back();
        }
        if($attachment->qa->uid != auth()->user()->id)
        {
            return back();
        }
        if(file_exists(public_path('uploads'.$attachment->file_path)))
        {
            unlink(public_path('uploads'.$attachment->file_path));
        }
        $attachment->delete();

        return response()->redirectToRoute('edit-qa', $attachment->qa->uuid);
    }

    public function attachmentDownload($id)
    {
        $file = QnaAttachment::find($id);
        if(is_null($file)){
            return redirect()->back();
        }
        if(!file_exists(public_path('uploads'.$file->file_path))){
            return redirect()->back();
        }

        return response()->download(public_path('uploads'.$file->file_path, $file->file_name));
    }
}
