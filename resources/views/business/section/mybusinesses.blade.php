<div class="col-md-12 panel panel-default" id="my-places">
    <div class="panel-heading">
        My businesses
    </div>

    <div class="panel-body">

        @if(count($myBusinesses) )
            <table class="table table-striped book-table">


                <tbody>
                <!-- Table Headings -->
                <thead>
                <tr>
                    <th>Businesses</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>

                <!-- Table Body -->
                @foreach($myBusinesses as $myBusiness)
                    <tr>
                        <!-- Business Name -->
                        <td class="table-text">
                            <div>{{$myBusiness->name }}</div>
                        </td>

                        <td>
                        </td>
                        <td>
                            <form action="/business/{{$myBusiness->id}}" method="POST">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE">

                                <button class="btn-default btn">Delete Business</button>
                            </form>
                            <button class="btn-default btn" id="df_1" >View Business</button>

                            <a href="/business/edit/{{$myBusiness->id }}">
                                <button class="btn-default btn">Edit Business</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <span>You have not listed any businesses yet</span>
        @endif
    </div>
</div>
