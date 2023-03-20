<?php
$categories = \App\Models\Category::all();
?>
<div class="section col-12">
    <h2>Category</h2>
    <ul>
        @foreach($categories as $category)
            <li><a href="/category/{{ $category->slug }}">{{ $category->name }}</a></li>
        @endforeach
    </ul>
</div>
