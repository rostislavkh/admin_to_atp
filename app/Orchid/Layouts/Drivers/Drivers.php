<?php

namespace App\Orchid\Layouts\Drivers;

use Orchid\Screen\TD;
use App\Models\Driver;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;

class Drivers extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'drivers';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', __('ID')),
            TD::make('src_img', 'Image link')->render(function (Driver $model) {
                return $model->getSrc() ? '<img src="' . $model->getSrc() . '" alt="img" style="max-height: 100px;" class="mw-100 d-block img-fluid">' : 'No image';
            }),
            TD::make('email', 'Email')->sort()->filter(),
            TD::make('salary', 'Salary')->sort()->filter(),
            TD::make('first_name', 'First name')->sort()->filter(),
            TD::make('last_name', 'Last name')->sort()->filter(),
            TD::make('birthday', 'Birthday')->sort()->filter(TD::FILTER_DATE_RANGE),
            TD::make('actions', __('Actions'))->render(function (Driver $model) {
                return DropDown::make()
                    ->icon('options-vertical')
                    ->list([
                        ModalToggle::make(__('Edit'))->modal('edit')->method('update')->icon('pencil')->modalTitle(__('Edit driver №') . $model->id)->asyncParameters(['model' => $model->id]),
                        Button::make(__('Remove'))->icon('trash')->confirm(__('Are you sure?'))->method('remove', [
                            'id' => $model->id
                        ]),
                    ]);
            })
        ];
    }
}
