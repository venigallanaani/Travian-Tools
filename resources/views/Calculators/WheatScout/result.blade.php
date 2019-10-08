@extends('Calculators.WheatScout.display')

@section('result')
	<div class="card float-md-left my-1 p-0 col-md-12 shadow">
        <div class="card-header h4 py-2 bg-primary text-white col-md-12">
            <strong>Result</strong>
        </div>
        <div class="card-text mx-auto text-center mt-2">
        	<table class="table table-borderless mx-auto">
        		<tr>
        			<td>Crop Diff - {{$result['diff']}}</td>
        			<td>Crop Diff/Hr - {{$result['cons']}}</td>
        		</tr>
        		<tr>
        			<td>Defense Cons - {{$result['defUp']}}</td>
        			<td>Reins Cons - {{$result['reinUp']}}</td>
        		</tr>
        		<tr>
        			<td>Total Cons - {{$result['defUp'] + $result['reinUp']}}</td>
        			<td>Cons missing - {{$result['cons'] - $result['defUp'] + $result['reinUp']}}</td>
        		</tr>
        	</table>
		
			@php print_r($result) @endphp
		</div>
	</div>

@endsection