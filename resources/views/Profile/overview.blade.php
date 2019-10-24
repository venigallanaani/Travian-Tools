@extends('Profile.template')
@section('body')

	<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
		<div class="card-header h4 py-2 bg-warning text-white">
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
				<div class="card-header h4 py-2 bg-warning text-white text-center">
					<strong>Contact Details</strong>
				</div>
				<div class="card-text">
					<table class="table table-hover col-md-8 mx-auto text-center">
						<tr>
							<td class="text-right ">Skype :</td>
							<td contenteditable="true" class="text-left " id="skypeEdit">{{ $contact['skype'] }}</td>
						</tr>
						<tr>
							<td class="text-right ">Discord :</td>
							<td contenteditable="true" class="text-left " id="discordEdit">{{ $contact['discord'] }}</td>
						</tr>
						<tr>
							<td class="text-right ">Phone :</td>
							<td contenteditable="true" class="text-left " id="phoneEdit">{{ $contact['phone'] }}</td>
						</tr>
					</table>
					<form id="form" action="{{route('profileContact')}}" method="POST" onsubmit="return getContent()" class="text-center pb-3">
						{{ csrf_field() }}
						<input id="skype" name="skype" style="display:none">
						<input id="discord" name="discord" style="display:none">
						<input id="phone" name="phone" style="display:none">
						<button class="btn btn-warning btn-lg px-5" type="submit">Save</button>						
					</form>					
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

