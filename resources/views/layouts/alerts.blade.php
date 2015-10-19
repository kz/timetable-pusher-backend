@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
        <div class="card red">
            <div class="card-content"><span class="white-text">{{ $error }}</span></div>
        </div>
    @endforeach
@endif