@include('layouts/header')

<div class="callout large primary">
    <div class="row column text-center">
        <h1>Our Blog</h1>
        <h2 class="subheader">Such a Simple Blog Layout</h2>
    </div>
</div>

<div class="row medium-8 large-7 columns">
    @yield('content')
</div>

@include('layouts/footer')
