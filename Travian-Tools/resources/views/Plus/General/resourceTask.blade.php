@extends('Plus.template')

@section('body')
	<!-- ==================================== Main Content of the Resource Tasks overview Menu ================================= -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Resource Push for Player (village)</strong></div>
			<div class="card-text">
    <!-- ==================================== List of tasks is progress ======================================= -->		
                <div class="text-center col-md-11 mx-auto my-2 p-0">                                  
                    <form method="POST" action="/plus/resource/id">
                    	{{ csrf_field() }}
                        <table class="table col-md-10 table-borderless mx-auto text-left">
                            <tr>
                                <td class="py-1 col-md-5"><strong>Village: </strong><a href="" target="_blank">Player(village)</a></td>
                                <td class="py-1 col-md-7"><strong>Resource Target:</strong> 10000</td>
                            </tr>
                            <tr>
                                <td class="py-1 col-md-5"><strong>Resource Sent: </strong><input type="text" name="resource" required size='10'/></td>
                                <td class="py-1 col-md-7"><strong>Resource Collected:</strong> 5000 (50%)</td>
                            </tr>
                            <tr>
                                <td class="py-1 col-md-5"><strong>Multiplier: </strong>
                                    <select name="noof">
                                        <option value='1'>X 1</option>
                                        <option value='2'>X 2</option>
                                        <option value='3'>X 3</option>
                                    </select>
                                </td>
                                <td class="py-1 col-md-7"><strong>Resources Remaining:</strong> 5000</td>
                            </tr>
                            <tr>
                                <td class="py-1 col-md-5"><strong>Resource Preference:</strong> ANY</td>
                                <td class="py-1 col-md-7 text-success"><strong>Your Contribution:</strong> 1000</td>
                            </tr>
                            <tr>
                                <td><button class="btn btn-warning px-5">Submit</button></td>
                                <td class="py-1 col-md-7"><strong>Comments:</strong><small> Comments about the resource task will be here all the other stuff too</small></td>
                            </tr>
                        </table>
                    </form>
                </div>
			</div>
		</div>

@endsection