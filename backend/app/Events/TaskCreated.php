<?php

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;


class TaskCreated implements ShouldBroadcastNow {
    
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public function __construct(public Task $task){}
    public function broadcastOn(){ return new PrivateChannel('user.'.$this->task->user_id); }
    public function broadcastAs(){ return 'TaskCreated'; }
    public function broadcastWith(){ return ['id'=>$this->task->id,'title'=>$this->task->title,'status'=>$this->task->status]; }
}