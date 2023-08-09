<?php
namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Post;

class Posts extends Component
{
    public $posts, $title, $body, $post_id;
    public $isModalOpen = 0;
    public function render()
    {
        $this->posts = Post::all();
        return view('livewire.posts');
    }
    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }
    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }
    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }
    private function resetCreateForm(){
        $this->title = '';
        $this->body = '';
    }
    
    public function store()
    {
        $this->validate([
            'title' => ['required','max:20'],
            'body' => ['required', 'max:50']
        ]);
    
        Post::updateOrCreate(['id' => $this->post_id], [
            'title' => $this->title,
            'body' => $this->body,
        ]);
        session()->flash('message', $this->post_id ? 'Post updated.' : 'Post created.');
        $this->closeModalPopover();
        $this->resetCreateForm();
    }
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $this->post_id = $id;
        $this->title = $post->title;
        $this->body = $post->body;
    
    
        $this->openModalPopover();
    }
    
    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Post deleted.');
    }
}