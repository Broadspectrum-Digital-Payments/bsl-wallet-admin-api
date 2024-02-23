<?php

use Illuminate\Pagination\LengthAwarePaginator;


/**
 * Retrieves paginated data from a LengthAwarePaginator.
 *
 * @param LengthAwarePaginator $paginator The paginator instance to retrieve data from.
 * @param int $pageSize The number of items per page.
 * @return array An array containing the paginated data with the following keys:
 * - 'previousPage': The URL of the previous page.
 * - 'nextPage': The URL of the next page.
 * - 'currentPage': The current page number.
 * - 'onLastPage': Indicates if the current page is the last page.
 * - 'onFirstPage': Indicates if the current page is the first page.
 * - 'total': The total number of items.
 * - 'pageSize': The number of items per page.
 */
function getPaginatedData(LengthAwarePaginator $paginator, int $pageSize): array
{
    $paginatorArray = $paginator->toArray();

    return [
        'firstPageUrl' => $paginatorArray['first_page_url'],
        'previousPage' => $paginator->previousPageUrl(),
        'nextPage' => $paginator->nextPageUrl(),
        'lastPageUrl' => $paginatorArray['last_page_url'],
        'currentPage' => $paginator->currentPage(),
        'onLastPage' => $paginator->onLastPage(),
        'onFirstPage' => $paginator->onFirstPage(),
        'total' => $paginator->total(),
        'pageSize' => $pageSize,
        'path' => $paginator->path(),
        'from' => $paginator->toArray()['from'],
        'to' => $paginator->toArray()['to'],
        'numberOfRecords' => $paginator->count(),
        'hasPages' => $paginator->hasPages()
    ];
}
