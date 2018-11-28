@section('leaderMenu')
            <!-- =================================== Plus Leader/Owner menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Leader Menu</a>
                <a href="/leader/access" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Access</a>
                <a href="/leader/subscription" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Subscription</a>
            </div>
@endsection

@section('defenseMenu')
            <!-- =================================== Defense menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Defense Menu</a>
                <a href="#1" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Incomings</a>
                <a href="#2" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Create CFD</a>
                <a href="#2" class="list-group-item py-1 list-group-item-action bg-info text-white h5">CFD Status</a>
                <a href="#2" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Search Defense</a>
            </div>
@endsection

@section('offenseMenu')
            <!-- =================================== Offense menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Offense Menu</a>                 
                <a href="#1" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Ops Status</a>
                <a href="#2" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Troops Details</a>
                <a href="#2" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Archive</a>                  
            </div>
@endsection

@section('resourceMenu')
    <!-- =================================== Resource menu ================================== -->
    <div class="list-group text-center text-white mt-1">
        <a class="list-group-item py-1 bg-dark h4">Resource Menu</a>
        <a href="#1" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Create Push</a>
        <a href="#2" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Push Status</a>
    </div>
@endsection