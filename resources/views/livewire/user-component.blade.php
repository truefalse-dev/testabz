<div class="container container-small">
    <div class="row">
        <div class="col-3">
            <form wire:submit="save">
                <div class="card p-3">
                    <div class="form-group mb-3">
                        <label for="name" class="control-label">Name:</label>
                        <input id="name" class="form-control" type="text" wire:model="name">
                        @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">E-mail:</label>
                        <input id="email" class="form-control" type="text" wire:model="email">
                        @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone">Phone: <span class="text-muted">should starts from +380</span></label>
                        <input id="phone" class="form-control" type="text" wire:model="phone">
                        @error('phone') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="position">Position:</label>
                        <select id="position" class="form-control" wire:model="position_id">
                            @foreach($positions as $position_id => $name)
                                <option value="{{ $position_id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('position_id') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="photo">Photo:</label>
                        <input id="photo" class="form-control" type="file" wire:model="photo">
                        @error('photo') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button class="btn btn-success" type="submit">Save</button>
                </div>
            </form>
        </div>

        <div class="col-9">
            <div class="card p-3">
                @foreach ($users as $user)
                    <div class="row" wire:key="{{ $user->id }}">
                        <div class="col-2">
                            <img class="rounded-circle" width="70px" src="{{ isset($user->photo) ? $user->photo : $this->placeholder }}"> 
                        </div>
                        
                        <div class="col-10">
                            <div>
                                <h5>{{ $user->name }}</h5>
                            </div>
                            <div>
                                <div class="badge bg-light text-secondary">E-mail: {{ $user->email }}</div> 
                                <div class="badge bg-light text-secondary">Position: {{ $user->position }}</div>
                                <div class="badge bg-light text-secondary">Phone: {{ $user->phone }}</div>
                                <hr/>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($hasMore)
                <button
                    type="button"
                    class="btn btn-primary btn-block" 
                    wire:click="showMore"
                >
                    Show more
                </button>
                @endif
            </div>    
        </div>  
    </div>      
</div>
