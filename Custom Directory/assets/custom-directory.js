document.addEventListener('DOMContentLoaded', function() {
    const directoryListings = document.querySelectorAll('.business-listing');
    
    directoryListings.forEach(listing => {
        const rating = listing.querySelector('.business-details strong:contains("Ratings:")');
        
        if (rating) {
            rating.addEventListener('click', function() {
                alert('Rating clicked!');
            });
        }
    });
});

jQuery(document).ready(function($) {
    // Initialize DataTables
    $('#business-directory-table').DataTable();
    
    $('.popup-trigger').hover(function () {
        var $this = $(this);
        $this.append('<div class="popup">' + $this.data('popup') + '</div>');
    }, function () {
        $('.popup').remove();
    });
});