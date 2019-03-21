@extends('Calculators.Cropper.Display')

@section('result')

<!-- ===================================== Neighbour Finder output -- village not available ======================================= -->
	<div class="card float-md-left my-1 p-0 col-md-12 shadow">
        <div class="card-header h4 py-2 bg-primary text-white">
            <strong>Cropper Development Sequence</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-11">
            <table class="table table-hover table-sm small">
                <tr class="h6 text-primary">
                	<th>#</th>
                    <th class="px-0" data-toggle="tooltip" data-placement="top" title="Flour Mill"><img alt="" src="/images/x.gif" class="build fm"></th>
                    <th class="px-0" data-toggle="tooltip" data-placement="top" title="Bakery"><img alt="" src="/images/x.gif" class="build bkry"></th>
                    <th class="px-0" data-toggle="tooltip" data-placement="top" title="Hero Mansion"><img alt="" src="/images/x.gif" class="build hm"></th>
                    <th colspan="3" class="px-3">Oasis</th>
                    <th>Crop Tiles</th>
                    <th>Description</th>
                    <th>Production</th>
                </tr>
                @foreach($steps as $index=>$step)
                <tr class="{{$step['FONT']}}">  
                	<td class="px-0">{{$index+1}}</td>              
                    <td class="px-0 text-success">{{$step['INFRA'][0]}}</td>
                    <td class="px-0 text-success">{{$step['INFRA'][1]}}</td>
                    <td class="px-0 text-success">{{$step['INFRA'][2]}}</td>
                    <td class="px-0 text-warning">{{$step['OASIS'][0]}}</td>
                    <td class="px-0 text-warning">{{$step['OASIS'][1]}}</td>
                    <td class="px-0 text-warning">{{$step['OASIS'][2]}}</td>
                    <td class="px-2 text-info">{{$step['FIELDS']}}</td>
                    <td class="px-2 text-info">{{$step['DESC']}}</td>
                    <td class="px-2">{{$step['PROD']}}</td>
                </tr>
                @endforeach
            </table>      
        </div>
    </div>

@endsection