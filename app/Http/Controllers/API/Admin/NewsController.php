<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\NewsContent;

class NewsController extends Controller
{
    //
    private $newsContent;

    public function __construct(Request $request)
    {
        $this->newsContent = new NewsContent;
    }

    public function index(Request $request)
    {
        $query = NewsContent::select(
            $this->newsContent->getTable() . '.news_id AS id',
            $this->newsContent->getTable() . '.title',
            $this->newsContent->getTable() . '.author',
            $this->newsContent->getTable() . '.created_at AS post_date',
            $this->newsContent->getTable() . '.status'
        )
            ->whereNull($this->newsContent->getTable() . '.deleted_at')
            ->orderBy($this->newsContent->getTable() . '.news_id');

        // Áp dụng bộ lọc theo trạng thái
        if ($request->has('status')) {
            $status = $request->input('status');
            $query->where($this->newsContent->getTable() . '.status', $status);
        }

        // Áp dụng bộ lọc từ khóa
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where($this->newsContent->getTable() . '.title', 'LIKE', "%$keyword%")
                    ->orWhere($this->newsContent->getTable() . '.author', 'LIKE', "%$keyword%");
            });
        }

        $newsContents = $query->paginate(10);

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'newsContents' => $newsContents->items(),
            'total_pages' => $newsContents->lastPage(),
        ]);
    }
    public function store(Request $request)
    {
        $this->newsContent->title = $request->input('title');
        $this->newsContent->content = $request->input('content');
        $this->newsContent->author = $request->input('author');
        $this->newsContent->status = $request->input('status');
        $this->newsContent->created_at = date('Y-m-d H:i:s');
        $this->newsContent->save();

        return response()->json([
            'status' => 200,
            'message' => 'News Contents added Successfully!',
        ]);
    }

    public function edit($id)
    {
        $newsContent = NewsContent::select(
            $this->newsContent->getTable() . '.news_id AS id',
            $this->newsContent->getTable() . '.title',
            $this->newsContent->getTable() . '.content',
            $this->newsContent->getTable() . '.author',
            $this->newsContent->getTable() . '.status',
            $this->newsContent->getTable() . '.created_at',

        )
            ->where($this->newsContent->getTable() . '.news_id', $id)
            ->first();

        return response()->json([
            'status' => 200,
            'newsContent' => $newsContent,
        ]);
    }

    public function update(Request $request, $id)
    {
        $newsContent = $this->newsContent::find($id);
        $newsContent->title = $request->input('title');
        $newsContent->content = $request->input('content');
        $newsContent->author = $request->input('author');
        $newsContent->status = $request->input('status');
        $newsContent->updated_at = date('Y-m-d H:i:s');
        $newsContent->update();
      
        return response()->json([
            'status' => 200,
            'message' => 'News Content Update Successfully!',
        ]);
    }

    public function delete($id)
    {
        $newsContent = $this->newsContent::find($id);
        $newsContent->deleted_at = date('Y-m-d H:i:s');
        $newsContent->update();
        return response()->json([
            'status' => 200,
            'message' => 'News Content Delete Successfully!',
        ]);
    }
}
