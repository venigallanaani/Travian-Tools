@extends('Calculators.Trade.display')

@section('result')
	<div class="card float-md-left my-1 p-0 col-md-12 shadow mb-5">
        <div class="card-header h5 py-1 bg-primary text-white col-md-12">
            <strong>Trade Routes Schedule</strong>
        </div>
        <div class="card-text mx-auto text-center my-3">
			<p class=""><span class="px-5">Deliveries - <strong>x {{$result['del']}}</strong></span>
				<span class="px-5">Frequency - <strong>every {{$result['freq']}}</strong></span>
			</p>
			<p class="mx-auto h6">Trade Route - 
				<span class="px-1"><img alt="wood" src="/images/x.gif" class="res wood"> {{number_format($result['wood'])}}</span>
				<span class="px-1"><img alt="clay" src="/images/x.gif" class="res clay"> {{number_format($result['clay'])}}</span>
				<span class="px-1"><img alt="iron" src="/images/x.gif" class="res iron"> {{number_format($result['iron'])}}</span>
				<span class="px-1"><img alt="crop" src="/images/x.gif" class="res crop"> {{number_format($result['crop'])}}</span>	
			</p>
			<p class="mx-auto h6 py-2">Resources/Delivery - 
				<img alt="all" src="/images/x.gif" class="res all"> {{number_format($result['wood']+$result['clay']+$result['iron']+$result['crop'])}}
			</p>
			<p>
		</div>
	@if($result['message']!=null)
		<p class="h6 font-italic text-danger text-center">{{$result['message']}}</p>
	@endif
	</div>

@endsection