@extends('Plus.template')

@section('body')
	<!-- ==================================== Main Content of the Resource Tasks overview Menu ================================= -->
		<div class="card float-md-left col-md-9 mt-1 mb-5 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Resource Push for {{$task['player']}}({{$task['village']}})</strong></div>
			<div class="card-text">
    <!-- ==================================== List of tasks is progress ======================================= -->		
                <div class="text-center col-md-11 mx-auto my-2 p-0">                                  
                    <form method="POST" action="/plus/resource/update">
                    	{{ csrf_field() }}
                        <table class="table col-md-10 table-borderless mx-auto">
                            <tr>
                                <td class="py-1 "><strong>Village: <a href="https://{{Session::get('server.url')}}/karte.php?x={{$task['x']}}&y={{$task['y']}}" target="_blank">{{$task['player']}}({{$task['village']}})</a></strong></td>
                                <td class="py-1 "><strong>Resource Target:</strong> {{number_format($task['res_total'])}}</td>
                            </tr>
                            <tr>
                                <td class="py-1 "><strong>Resource Sent: </strong><input type="number" min="0" name="res" required size='3'/></td>
                                <td class="py-1 "><strong>Resource Collected:</strong> {{number_format($task['res_received'])}} ({{$task['res_percent']}}%)</td>
                            </tr>
                            <tr>
                                <td class="py-1 "><strong>Multiplier: </strong>
                                    <select name="noof">
                                        <option value='1'>X 1</option>
                                        <option value='2'>X 2</option>
                                        <option value='3'>X 3</option>
                                    </select>
                                </td>
                                <td class="py-1 "><strong>Resources Remaining:</strong> {{number_format($task['res_remain'])}}</td>
                            </tr>
                            <tr>
                                <td class="py-1 "><strong>Resource Preference:</strong> 
                                	<span data-toggle="tooltip" data-placement="top" title="{{$task['type']}}"><img alt="{{$task['type']}}" src="/images/x.gif" class="res {{$task['type']}}"></span></td>
                                <td class="py-1  text-info"><strong>Your Contribution:</strong> {{number_format($player['resources']) ?? 0}}</td>
                            </tr>
                            <tr>
                                <td><button class="btn btn-warning px-5" name="update" value="{{$task['task_id']}}"><strong>Submit</strong></button></td>
                                <td class="py-1 "><strong>Comments:</strong><small> {{$task['comments']}}</small></td>
                            </tr>
                        </table>
                    </form>
                </div>
			</div>
		</div>
@endsection