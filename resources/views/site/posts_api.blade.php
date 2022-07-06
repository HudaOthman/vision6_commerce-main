@extends('site.master')

@section('content')

    <main class="ps-main">
      <div class="ps-checkout pt-80 pb-80">
        <div class="ps-container">

            <button onclick="getPosts()" class="btn btn-success">Load Posts</button>
            <div class="posts-wrapper"></div>
            {{-- @foreach ($posts as $post)
            <h2>{{ $post['title'] }}</h2>
            <p>{{ $post['body'] }}</p>
            <hr>

            @endforeach --}}
        </div>
      </div>
@stop

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function getPosts() {
        let content = '';
        axios.get('https://jsonplaceholder.typicode.com/posts')
            .then(res => {
                res.data.forEach(el => {
                    // console.log(el);
                    content += `
                    <h2>${el.title}</h2>
                    <p>${el.body}</p>
                    <hr>
                    `;
                });

                // console.log(content);

                document.querySelector('.posts-wrapper').innerHTML = content;
            })
    }
</script>

@stop
