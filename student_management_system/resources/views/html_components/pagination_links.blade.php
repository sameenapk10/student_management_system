<div class="row justify-content-end">
    <ul class="pagination mt-2" ng-show="pager.currentPage">
        <li class="page-item" ng-class="{disabled:pager.currentPage === 1}">
            <a href="javascript:;" class="page-link" ng-click="setPage(1)">«</a>
        </li>
        <li class="page-item" ng-class="{disabled:pager.currentPage === 1}">
            <a href="javascript:;" class="page-link" ng-click="setPage(pager.currentPage - 1)">&lsaquo;</a>
        </li>
        <li class="page-item" ng-repeat="page in pager.pages" ng-class="{active:pager.currentPage === page}">
            <a href="javascript:;" class="page-link" ng-click="setPage(page)">@{{page}}</a>
        </li>
        <li class="page-item" ng-class="{disabled:pager.currentPage === pager.totalPages}">
            <a href="javascript:;" class="page-link" ng-click="setPage(pager.currentPage + 1)">&rsaquo;</a>
        </li>
        <li class="page-item" ng-class="{disabled:pager.currentPage === pager.totalPages}">
            <a href="javascript:;" class="page-link" ng-click="setPage(pager.totalPages)">»</a>
        </li>
    </ul>
</div>
