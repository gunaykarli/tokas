var DatatablesBasicPaginations = function() {

	var initTable1 = function() {
		alert(1);
		var table = $('#m_table_1');

		// begin first table
		table.DataTable({
			responsive: true,
			pagingType: 'full_numbers',
            /*
            columnDefs: [
                {
                    targets: -1,
                    title: 'Action',
                    orderable: false,

                    render: function(data, type, full, meta) {
                        return `
                        <span class="dropdown">
                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                              <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item"  href="/provider/create" ><i class="la la-edit"></i>Create</a>
                                <a class="dropdown-item" href="/provider/update"><i class="la la-leaf"></i>Update </a>
                                <a class="dropdown-item" href="/provider/delete/{{$provider->id}}"><i class="la la-print"></i>Delete</a>
                            </div>
                        </span>
                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">
                          <i class="la la-edit"></i>
                        </a>`;
                    },

				},
			],
			*/
		});
	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
	DatatablesBasicPaginations.init();
});