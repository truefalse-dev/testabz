<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UserPosition;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class UserComponent extends Component
{
    use WithFileUploads;

    // form
    public $name = '';
    public $email = '';
    public $phone = '';
    public $position_id = 1;
    public $photo;
    public $placeholder;

    public int $page = 1;
    public bool $hasMore = true;
    public array $users = [];
    public Collection $positions;

    /**
     * @throws \JsonException
     */
    public function mount(): void
    {
        $this->positions = UserPosition::query()->pluck('name', 'id');
        $this->users = $this->getList();
    }

    private function getList(): array
    {
        $this->placeholder = env('APP_URL') . '/placeholder.png';

        $url = env('APP_URL') . '/api/v1/users?count=6&page='.$this->page;

        $client = Http::withUserAgent('livewire-agent');

        $response = $client->get($url);
        $collection = json_decode($response, false, 512, JSON_THROW_ON_ERROR);

        if ($this->page >= $collection->meta->last_page) {
            $this->hasMore = false;
        }

        return collect($collection->users)->all();
    }

    public function showMore(): void
    {
        ++$this->page;
        $this->users = array_merge($this->users, $this->getList());
    }

    public function save()
    {
        $this->resetErrorBag();

        $url = env('APP_URL') . '/api/v1/users';

        $client = Http::withUserAgent('livewire-agent');

        if (isset($this->photo)) {
            $tempFile = TemporaryUploadedFile::createFromLivewire($this->photo->getFilename());
            $name = File::get($tempFile->path());
            $client->attach('photo', $name, $this->photo->getFilename());
        }

        $response = $client->post($url, [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'position_id' => $this->position_id,
            ]);

        $collection = json_decode($response, false, 512, JSON_THROW_ON_ERROR);

        if (isset($collection->errors->name)) {
            $this->addError('name', $collection->errors->name[0]);
        }

        if (isset($collection->errors->email)) {
            $this->addError('email', $collection->errors->email[0]);
        }

        if (isset($collection->errors->phone)) {
            $this->addError('phone', $collection->errors->phone[0]);
        }

        if (isset($collection->errors->position_id)) {
            $this->addError('position_id', $collection->errors->position_id[0]);
        }

        if (isset($collection->errors->photo)) {
            $this->addError('photo', $collection->errors->photo[0]);
        }

        $this->page = 1;
        $this->users = $this->getList();
    }

    /**
     * @throws \JsonException
     */
    public function render()
    {
        return view('livewire.user-component')->with([
            'users' => $this->users,
            'positions' => $this->positions,
        ]);
    }
}
