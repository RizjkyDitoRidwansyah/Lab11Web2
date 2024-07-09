<?= $this->include('template/admin_header'); ?>

<div class="container">
    <form method="get" class="form-search">
        <input type="text" name="q" value="<?= $q; ?>" placeholder="Cari data">
        <input type="submit" value="Cari" class="btn btn-primary">
    </form>

    <table class="container" id="artikelTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <?= $pager->only(['q'])->links(); ?>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // Function to display a loading message while data is fetched
        function showLoadingMessage() {
            $('#artikelTable tbody').html('<tr><td colspan="4">Loading data... < /td></tr > ');
        }
        // Buat fungsi load data
        function loadData() {
            showLoadingMessage(); // Display loading message initially
            // Lakukan request AJAX ke URL getData
            $.ajax({
                url: "<?= base_url('/ajax/getData') ?>",
                method: "GET",
                dataType: "json",
                success: function(data) {
                    // Tampilkan data yang diterima dari server
                    var tableBody = "";
                    for (var i = 0; i < data.length; i++) {
                        var row = data[i];
                        tableBody += '<tr>';
                        tableBody += '<td>' + row.id + '</td>';
                        tableBody += '<td>' + row.judul + '</td>';
                        // Add a placeholder for the "Status" column (modify as needed)

                        tableBody += '<td><span class="status">---</span></td > ';

                        tableBody += '<td>';
                        // Replace with your desired actions (e.g., edit,delete)

                        tableBody += '<a href="<?= base_url('/admin/artikel/edit/') ?>/' + row.id + '" class="btn btn-primary">Edit</a>';
                        tableBody += '<a href="<?= base_url('/admin/artikel/delete/') ?>/' + row.id + '" onclick="return confirm(\'Yakin menghapus data?\');" class="btn btn-danger btn - delete " data-id=" ' + row.id + '">Delete</a>';
                        tableBody += '</td>';
                        tableBody += '</tr>';
                    }
                    $('#artikelTable tbody').html(tableBody);
                }
            });
        }
        loadData();
        // Implement actions for buttons (e.g., delete confirmation)
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            // Add confirmation dialog or handle deletion logic here
            // hapus data;
            if (confirm('Apakah Anda yakin ingin menghapus artikel ini?'))

            {
                $.ajax({
                    url: "<?= base_url('artikel/delete/') ?>" + id,
                    method: "DELETE",
                    success: function(data) {
                        loadData(); // Reload Datatables to reflect changes
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error deleting article: ' + textStatus +

                            errorThrown);
                    }
                });
            }
            console.log('Delete button clicked for ID:', id);
        });
    });
</script>

<?= $this->include('template/admin_footer'); ?>