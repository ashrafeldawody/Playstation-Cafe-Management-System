<?php

namespace App\DataTables;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InventoryDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('item', function (Inventory $inventory) {
                return $inventory->item->name;
            })
            ->addColumn('type', function (Inventory $inventory) {
                if ($inventory->type == 'SELL') {
                    return '<h4><span class="badge badge-success">بيع</span></h4>';
                }
                if ($inventory->type == 'BUY') {
                    return '<h4><span class="badge badge-primary">شراء</span></h4>';
                }
                if ($inventory->type == 'RETURN') {
                    return '<h4><span class="badge badge-danger">مرتجع</span></h4>';
                }
                if ($inventory->type == 'DEFECT') {
                    return '<h4><span class="badge badge-danger">تالف</span></h4>';
                }
                if ($inventory->type == 'LOST') {
                    return '<h4><span class="badge badge-danger">مفقود</span></h4>';
                }
            })
            ->addColumn('created_at', function (Inventory $inventory) {
                return $inventory->created_at->format('Y-m-d h:i a');
            })
            ->addColumn('updated_at', function (Inventory $inventory) {
                return $inventory->updated_at->format('Y-m-d h:i a');
            })
            ->rawColumns(['type'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Inventory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Inventory $model): QueryBuilder
    {
        return $model->with('item')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('inventory-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('type')->title('النوع'),
            Column::make('bill_id')->title('رقم الفاتورة'),
            Column::make('item')->title('الصنف'),
            Column::make('quantity')->title('الكمية'),
            Column::make('created_at')->title('تاريخ الإضافة'),
            Column::make('updated_at')->title('تاريخ التعديل'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Inventory_' . date('YmdHis');
    }
}
