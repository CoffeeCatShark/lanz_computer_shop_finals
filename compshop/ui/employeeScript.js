// Confirm before deleting
document.addEventListener('DOMContentLoaded', function() {
    // Confirm deletion
    const deleteButtons = document.querySelectorAll('.btn-danger');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this record?')) {
                e.preventDefault();
            }
        });
    });

    // File link handling
    const fileLinks = document.querySelectorAll('a[href*="../docs/"]');
    fileLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.getAttribute('href') === "../docs/") {
                e.preventDefault();
                alert('No file available for this request.');
            }
        });
    });

    // Add animation to table rows
    const tableRows = document.querySelectorAll('tr');
    tableRows.forEach((row, index) => {
        // Skip header row
        if (index > 0) {
            row.style.opacity = '0';
            setTimeout(() => {
                row.style.transition = 'opacity 0.5s ease';
                row.style.opacity = '1';
            }, index * 100);
        }
    });
});