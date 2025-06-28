jQuery(document).ready(function ($) {
   const pluginSlug = 'events-calendar-for-google';

    const deactivateLink = $(`tr[data-slug="${pluginSlug}"] .deactivate a`);

    deactivateLink.on('click', function (e) {
        e.preventDefault(); 
        const deactivateUrl = $(this).attr('href');

        Swal.fire({
            title: 'Deactivate plugin?',
            text: 'Are you sure you want to deactivate this plugin?',
            showCancelButton: true,
            confirmButtonText: 'Yes, deactivate',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#08267c',
            cancelButtonColor: '#1f57bc'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deactivateUrl;
            }
        });
    });
});

// This script adds a confirmation dialog when the user attempts to deactivate the "Events Calendar for Google" plugin.
