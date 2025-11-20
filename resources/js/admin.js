import './bootstrap';

if (document.querySelector(".bulk-actions-dropdown")) {
    const selectAllCheckbox = document.getElementById("select-all");
    const checkboxes = document.querySelectorAll(".checkbox");
    const bulkActions = document.querySelector(".bulk-actions-dropdown");

    // Toggle tất cả checkbox khi nhấn vào "Chọn tất cả"
    selectAllCheckbox.addEventListener("change", function () {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        toggleBulkActions();
    });

    // Hiển thị dropdown nếu có ít nhất một checkbox được chọn
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", toggleBulkActions);
    });

    function toggleBulkActions() {
        const checkedCount = document.querySelectorAll(".checkbox:checked").length;
        bulkActions.style.display = checkedCount > 0 ? "block" : "none";
    }
}

document.addEventListener('DOMContentLoaded', function () {
    let currentDelete = {
        id: null,
        type: null, // ví dụ: 'product', 'category', 'post'
    };

    window.deleteResource = function(id, type) {
        currentDelete.id = id;
        currentDelete.type = type;
        UIkit.modal('#deleteModal').show();
    };

    window.confirmDelete = function() {
        if (!currentDelete.id || !currentDelete.type) {
            alert('Không xác định được đối tượng để xoá!');
            return;
        }

        const url = `/admin/${currentDelete.type}/${currentDelete.id}`;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ _method: 'DELETE' })
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Không thể xoá. Đã xảy ra lỗi.');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Lỗi kết nối tới máy chủ.');
        });
    };

});
