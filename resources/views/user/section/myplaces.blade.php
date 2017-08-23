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
                            <div>Tinau Technical Project Proposal</div>
                        </td>

                        <td>
                        </td>
                        <td>
                            <form action="/book/1" method="POST">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE">

                                <button class="btn-default btn">Delete Business</button>
                            </form>
                            <button class="btn-default btn" id="df_1" >View Business</button>

                            <a href="/business/edit/1">
                                <button class="btn-default btn">Edit Business</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <span>You have not listed any businesses yet</span>
        @endif
        {{--  <tr>
              <!-- Book Name -->
              <td class="table-text">
                  <div>sadf</div>
              </td>

              <td>
              </td>
              <td>
                  <form action="/book/2" method="POST">
                      <input type="hidden" name="_token" value="KnaQ38Q6PR2ZvyqmW3KZZGEtlx2ljx5XWMc2Q4lG">
                      <input type="hidden" name="_method" value="DELETE">

                      <button>Delete Book</button>
                  </form>
                  <button class="_df_button" id="df_2" source="pdf/149113632158e0ef4122a3c4.40789063" df-parsed="true">View Book</button>

                  <a href="/book/edit/2">
                      <button>Edit Book</button>
                  </a>
              </td>

          </tr>
          <tr>
              <!-- Book Name -->
              <td class="table-text">
                  <div>ajk</div>
              </td>

              <td>
              </td>
              <td>
                  <form action="/book/5" method="POST">
                      <input type="hidden" name="_token" value="KnaQ38Q6PR2ZvyqmW3KZZGEtlx2ljx5XWMc2Q4lG">
                      <input type="hidden" name="_method" value="DELETE">

                      <button>Delete Book</button>
                  </form>
                  <button class="_df_button" id="df_5" source="pdf/149143827358e58ac123e4c0.61375015" df-parsed="true">View Book</button>

                  <a href="/book/edit/5">
                      <button>Edit Book</button>
                  </a>
              </td>

          </tr>
          <tr>
              <!-- Book Name -->
              <td class="table-text">
                  <div>my new book</div>
              </td>

              <td>
              </td>
              <td>
                  <form action="/book/6" method="POST">
                      <input type="hidden" name="_token" value="KnaQ38Q6PR2ZvyqmW3KZZGEtlx2ljx5XWMc2Q4lG">
                      <input type="hidden" name="_method" value="DELETE">

                      <button>Delete Book</button>
                  </form>
                  <button class="_df_button" id="df_6" source="pdf/1502541459598ef693b30b15.24579848" df-parsed="true">View Book</button>

                  <a href="/book/edit/6">
                      <button>Edit Book</button>
                  </a>
              </td>

          </tr>--}}

    </div>
</div>
