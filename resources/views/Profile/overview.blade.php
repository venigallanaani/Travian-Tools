@extends('Profile.template')
@section('body')

	<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
		<div class="card-header h5 py-2 bg-warning text-white">
			<strong>Account Overview</strong>
		</div>
		<div class="card-text p-4">
			<table class="table table-borderless mx-3 text-left col-md-6 mx-auto">
				<tr>
					<td class="py-1"><strong><span class="text-warning">User Name</span></strong></td>
					<td class="py-1">: {{Auth::user()->name}}</td>
				</tr>
				<tr>
					<td class="py-1"><strong><span class="text-warning">Email Address</span></strong></td>
					<td class="py-1">: {{Auth::user()->email}}</td>
				</tr>
			</table>
			<div class="card shadow col-md-8 p-0 mx-auto">
				<div class="card-header h5 py-2 bg-warning text-white text-center">
					<strong>Contact Details</strong>
				</div>
				<div class="card-text" style="font-size: 1em">
					<table class="table table-hover col-md-8 mx-auto text-center">
						<tr>
							<td class="text-right" style="width:10em;"><strong>Skype :</strong></td>
							<td contenteditable="true" class="text-left " id="skypeEdit" style="width:10em;">{{ $contact['skype'] }}</td>
						</tr>
						<tr>
							<td class="text-right" style="width:10em;"><strong>Discord :</strong></td>
							<td contenteditable="true" class="text-left " id="discordEdit" style="width:10em;">{{ $contact['discord'] }}</td>
						</tr>
						<tr>
							<td colspan="2" class="text-center">
								<form id="form" action="{{route('profileContact')}}" method="POST" onsubmit="return getContent()" class="text-center pb-3">
            						{{ csrf_field() }}
            						<input id="skype" name="skype" style="display:none">
            						<input id="discord" name="discord" style="display:none">
            						<button class="btn btn-warning btn-lg px-5 py-1" type="submit">Save</button>						
            					</form>							
							</td>							
						</tr>
					</table>			
				</div>			
			</div>
		</div>
	</div>
@endsection

@push('scripts')
        <script>
            function getContent() {
    			skype=document.getElementById("skypeEdit").innerHTML;
    			if(skype=='<br>'){ skype='';}
                document.getElementById("skype").value = skype;
                
                discord=document.getElementById("discordEdit").innerHTML;
                if(discord=='<br>'){ discord='';}
                document.getElementById("discord").value = discord;

                phone=document.getElementById("phoneEdit").innerHTML;
                if(phone=='<br>'){ phone='';}
                document.getElementById("phone").value = phone;                
            }
    	</script>
@endpush

