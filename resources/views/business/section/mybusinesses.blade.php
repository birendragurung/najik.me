<div class="col-md-12 panel panel-default" id="my-places">
    <div class="panel-heading">
        My businesses
    </div>

    <div class="panel-body">

        @if(count($myBusinesses) )
            <div class="table-responsive">
                <table class="table table-striped book-table">
                    <tbody>
                    <!-- Table Headings -->
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Website</th>
                        <th>Verified</th>
                        <th>Category</th>
                        <th>Edit/View/Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Table Body -->
                    @foreach($myBusinesses as $myBusiness)
                        <tr>
                            <!-- Business Name -->
                            <td class="table-text">
                                <div>{{$myBusiness->name }}</div>
                            </td>
                            <td>
                                <div>{{$myBusiness->description }}</div>
                            </td>
                            <td>
                                <div><a href="{{$myBusiness->website }}">{{$myBusiness->website }}</a></div>

                            </td>
                            <td>
                                <div>{{$myBusiness->verified }}</div>

                            </td>
                            <td>
                                <div>{{$myBusiness->category->name  }}</div>
                            </td>

                            <td>
                                    <a href="/business/edit/{{$myBusiness->id }}">
                                        <button class="btn-default btn">Edit</button>
                                    </a>
                                    <a href="/business/{{$myBusiness->id}}">
                                        <button class="btn-default btn">View</button>
                                    </a>
                                <form action="/business/{{$myBusiness->id}}" method="POST">
                                    {{csrf_field()}}
                                    <input type="hidden" name="_method" value="DELETE">

                                    <button class="btn-default btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <span>You have not listed any businesses yet</span>
            <a href="/business/add">Add my business</a>
        @endif
    </div>
</div>
