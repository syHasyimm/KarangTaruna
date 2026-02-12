<?php

namespace App\Livewire\Voting;

use App\Models\Event;
use App\Models\Vote;
use Livewire\Component;

class WargaShow extends Component
{
    public Event $event;
    public string $choice = '';
    public bool $hasVoted = false;

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->hasVoted = Vote::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->exists();
    }

    public function submitVote()
    {
        $this->validate(['choice' => 'required|string']);

        if ($this->hasVoted) {
            session()->flash('error', 'Anda sudah memberikan suara.');
            return;
        }

        if ($this->event->status !== 'open') {
            session()->flash('error', 'Voting ini belum/sudah ditutup.');
            return;
        }

        Vote::create([
            'user_id' => auth()->id(),
            'event_id' => $this->event->id,
            'choice' => $this->choice,
        ]);

        $this->hasVoted = true;
        session()->flash('success', 'Suara Anda berhasil tercatat. Terima kasih!');
    }

    public function render()
    {
        $votes = $this->event->votes()->get();
        $results = $votes->groupBy('choice')->map->count();

        return view('livewire.voting.warga-show', [
            'votes' => $votes,
            'results' => $results,
            'totalVotes' => $votes->count(),
        ])->layout('layouts::landing');
    }
}
