@extends('Calculators.Cropper.Display')

@section('result')

<!-- ===================================== Neighbour Finder output -- village not available ======================================= -->
	<div class="card float-md-left my-1 p-0 col-md-12 shadow">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Cropper Development Sequence</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-11">
            <table class="table table-hover table-sm small">
                <tr class="h6">
                    <th class="px-0" data-toggle="tooltip" data-placement="top" title="Flour Mill"><img alt="" src="/images/x.gif" class="build fm"></th>
                    <th class="px-0" data-toggle="tooltip" data-placement="top" title="Bakery"><img alt="" src="/images/x.gif" class="build bkry"></th>
                    <th class="px-0" data-toggle="tooltip" data-placement="top" title="Hero Mansion"><img alt="" src="/images/x.gif" class="build hm"></th>
                    <th colspan="3" class="px-3">Oasis</th>
                    <th>Crop Tiles</th>
                    <th>Description</th>
                    <th>Production</th>
                </tr>
                @for($i=0;$i<100;$i++)
                <tr>                
                    <td class="px-0">5</td>
                    <td class="px-0">5</td>
                    <td class="px-0">20</td>
                    <td class="px-0">50</td>
                    <td class="px-0">50</td>
                    <td class="px-0">50</td>
                    <td class="px-2">21,21,21,21,21,21,21,21,21,21,21,21,21,21,21</td>
                    <td class="px-2">Upgrade crop tile to lvl 21</td>
                    <td class="px-2">220,000</td>
                </tr>
                @endfor
            </table>      
        </div>
    </div>

@endsection