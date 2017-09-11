@if (session()->has('status'))
    @foreach (session('status') as $status)
        <ul class="collection green" style="border:0 !important; margin-bottom: 5px !important;">
            <li class="collection-item green">{{ $status }}</li>
        </ul>
    @endforeach
@endif
@if (session()->has('success'))
    @foreach (session('success') as $success)
        <ul class="collection green" style="border:0 !important; margin-bottom: 5px !important;">
            <li class="collection-item green">{{ $success }}</li>
        </ul>
    @endforeach
@endif
@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
        <ul class="collection red" style="border:0 !important; margin-bottom: 5px !important;">
            <li class="collection-item red">{{ $error }}</li>
        </ul>
    @endforeach
@endif