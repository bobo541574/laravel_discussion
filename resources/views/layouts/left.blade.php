<div class="card shadow-lg border-0">
    <div class="card-body">
        <h5 class="card-title font-weight-bold"><i class="fa fa-list-ul" style="font-size: 16px"></i> Category</h5>
        <div class="dropdown-divider"></div>
        <ul class="list-group">
            @foreach ($categories as $category)
            <li class="list-group-item font-weight-bold link"><a href="{{ route('articles.category', $category->id) }}"
                    class="text-decoration-none text-dark d-block">{{$category->name}}</a></li>
            @endforeach
        </ul>
    </div>
</div>
