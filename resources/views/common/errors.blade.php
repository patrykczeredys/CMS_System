@if(count($errors) > 0)
<!-- Form Error List -->
<div class="alert alert-danger" role="alert">
    <h5 class="alert-heading">Something is Wrong</h5>
    <ul>
        @foreach($errors->all() as $error)
            <li>{!! $error !!}</li>
        @endforeach
    </ul>
</div>
@endif
