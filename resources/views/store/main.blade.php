@extends('layouts.main')

@section('content')

        <h1 class="my-4">Page Heading
          <small>Secondary Text</small>
        </h1>

        @foreach($posts as $post)
        <!-- Blog Post -->
        <div class="card mb-4">
          <a href="/store/view/{{ $post->id }}">{!! Html::image("img/posts/".$post->image, $post->title, array('width'=>'607', 'height'=>'400', 'class'=>'card-img-top')) !!}</a>
          <div class="card-body">
            <h2 class="card-title">{!! $post->title !!}</h2>
            <p class="card-text">{!! $post->short_desc !!}</p>
            <a href="/store/view/{{ $post->id }}" class="btn btn-primary">Read More &rarr;</a>
          </div>
          <div class="card-footer text-muted">
            Posted on {!! $post->created_at !!}
            <a href="#">{!! $post->author !!}</a>
          </div>
        </div>
        @endforeach

        <!-- Pagination -->
        <ul class="pagination justify-content-center mb-4">
          <li class="page-item">
            <a class="page-link" href="#">&larr; Older</a>
          </li>
          <li class="page-item disabled">
            <a class="page-link" href="#">Newer &rarr;</a>
          </li>
        </ul>

@endsection