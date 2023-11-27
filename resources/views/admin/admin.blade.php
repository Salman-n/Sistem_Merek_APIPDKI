@include('admin.modular.header')
<h1>Admin</h1>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adminUserModal">
    Tambah Admin
</button>
<hr>
<div class="table-responsive">
<table id="datatable" class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Waktu Daftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
            <td>{{$user->id}}</td>   
            <td>{{$user->name}}</td>
               <td>{{$user->email}}</td>
               <td>{{$user->created_at}}</td>
               <td>
                @if($user->id != Auth::guard("admin")->user()->id)
                <a href="/admin/pemohon/delete/{{$user->id}}"><button class="btn btn-danger">Hapus</button></a>
                @endif
               </td>
               
         
            </tr>
        @endforeach    
        </tbody>
    </table>
</div>
</div>

<div class="modal fade" id="adminUserModal" tabindex="-1" aria-labelledby="adminUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminUserModalLabel">Tambah Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for creating admin user -->
                <form id="adminUserForm">
                    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="createUserBtn">Create User</button>
            </div>
        </div>
    </div>
</div>


<script>
    // document ready
  
    $(document).ready(function(){
        new DataTable('#datatable');

        $('#createUserBtn').click(function() {
            // Validate the form
            var email = $('#email').val();
            var password = $('#password').val();
            var name = $('#name').val();

            if (name === "" || email === "" || password === "") {
                alert('Please fill in all fields.');
                return;
            }

            // Perform an AJAX POST to your desired URL
            $.ajax({
                type: 'POST',
                url: '/admin/admin/add',
                data: $('#adminUserForm').serialize(),
                success: function(response) {
                    // Handle the response here
                    console.log(response);
                    // Close the modal
                    $('#adminUserModal').modal('hide');
                    window.location.reload();
                },
                error: function(error) {
                    console.error(error);
                    alert('Error creating admin user.');
                }
            });
        });
});
    </script>
    @include('admin.modular.footer')