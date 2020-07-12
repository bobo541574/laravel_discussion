<div class="card shadow-lg border-0 mb-2">
    <div class="card-body">
        <h5 class="card-title font-weight-bold"><i class="fa fa-list-ul" style="font-size: 18px"></i> Category</h5>
        <div class="dropdown-divider"></div>
        <ul class="list-group">
            <li class="list-group-item link"><a href="{{ route('articles.index') }}"
                    class="text-decoration-none font-weight-bolder text-dark d-block" data-toggle="tooltip" title="All Categories">All</a></li>
            @foreach ($categories as $category)
            <li class="list-group-item link"><a href="{{ route('articles.index', 'category='.$category->id) }}"
                    class="text-decoration-none font-weight-bolder text-dark d-block"  data-toggle="tooltip" title="{{$category->name}}">{{$category->name}}</a></li>
            @endforeach
        </ul>
    </div>
</div>