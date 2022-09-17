<?php

namespace App\DataTables;

use App\Models\devicesCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class deviceCategoryDataTable extends DataTable
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
            ->addColumn('action', function ($device) {
                return '<div class="d-flex justify-content-evenly gap-3">
                <a href="' . route('device-categories.edit', $device->id) . '" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                <a href="' . route('device-categories.delete', $device->id) . '" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </div>';
            })
            ->addColumn('created_at', function ($device) {
                return $device->created_at->format('Y-m-d');
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\devicesCategory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(devicesCategory $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('devicecategory-table')
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
            Column::make('name')->title('اسم الجهاز'),
            Column::make('price')->title('سعر الساعة(عادي)'),
            Column::make('multi_price')->title('سعر الساعة(مالتي)'),
            Column::make('created_at')->title('تاريخ الانشاء'),
            Column::computed('action')
                ->title('العمليات')
                ->exportable(false)
                ->orderable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'deviceCategory_' . date('YmdHis');
    }
}
