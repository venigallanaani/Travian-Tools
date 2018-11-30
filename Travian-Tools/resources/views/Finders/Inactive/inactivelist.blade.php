@extends('Finders.Inactive.inactiveFinder')

@section('result')

<!-- ==================================== Inactive Finder Output -- List Inactives ==================================== -->
    <div class="card float-md-left shadow col-md-12 px-0 mb-1">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Inactive Results</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-12">
            <table id="sortableTable" class="table table-border-success table-hover table-sm small">
                <tr class="h6">
                    <th onclick="sortTable(0)" class="col-md-1">Distance</th>
                    <th onclick="sortTable(1)" class="col-md-2">Village</th>                    
                    <th onclick="sortTable(2)" class="col-md-2">Player</th>
                    <th onclick="sortTable(3)" class="col-md-2">Alliance</th>   
                    <th class="col-md-1">Tribe</th>
                    <th onclick="sortTable(4)" class="col-md-2">Pop<small>(+/- 7 days)</small></th>
                    <th onclick="sortTable(5)" class="col-md-2">Status</th>
                </tr>
                <tr>
                    <td class="py-0">1.1</td>
                    <td class="py-0"><a href="" target="_blank">Village 01</a></td>                    
                    <td class="py-0"><a href="">Player 01</a></td>
                    <td class="py-0"><a href="">Alliance 01</a></td>
                    <td class="py-0" data-toggle="tooltip" data-placement="top" title="Teuton"><img alt="" src="/images/x.gif" class="race teuton"></td>
                    <td class="py-0">100(0)</td>
                    <td class="text-dark py-0">Inactive</td>
                </tr>
                <tr>
                    <td class="py-0">2.2</td>
                    <td class="py-0"><a href="" target="_blank">Village 02</a></td>
                    <td class="py-0"><a href="">Player 02</a></td>
                    <td class="py-0"><a href="">Alliance 02</a></td>
                    <td class="py-0" data-toggle="tooltip" data-placement="top" title="Roman"><img alt="" src="/images/x.gif" class="race roman"></td>
                    <td class="py-0">600(-10)</td>
                    <td class="text-danger py-0">Under Attack</td>
                </tr>
                <tr>
                    <td class="py-0">4.3</td>
                    <td class="py-0"><a href="" target="_blank">Village 03</a></td>
                    <td class="py-0"><a href="">Player 03</a></td>
                    <td class="py-0"><a href="">Alliance 03</a></td>
                    <td class="py-0" data-toggle="tooltip" data-placement="top" title="Gaul"><img alt="" src="/images/x.gif" class="race gaul"></td>
                    <td class="py-0">300(0)</td>
                    <td class="text-dark py-0">Inactive</td>
                </tr>
                <tr>
                    <td class="py-0">8.4</td>
                    <td class="py-0"><a href="" target="_blank">Village 04</a></td>
                    <td class="py-0"><a href="">Player 04</a></td>
                    <td class="py-0"><a href="">Alliance 04</a></td>
                    <td class="py-0" data-toggle="tooltip" data-placement="top" title="Teuton"><img alt="" src="/images/x.gif" class="race teuton"></td>
                    <td class="py-0">400(0)</td>
                    <td class="text-dark py-0">Inactive</td>
                </tr>
            </table>
        </div>
    </div>

@endsection