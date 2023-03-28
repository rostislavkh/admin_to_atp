<?php

namespace App\Orchid\Layouts\Cars;

use Orchid\Screen\TD;
use App\Models\CarBrand;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;

class Brands extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'brands';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', __('ID')),
            TD::make('name', 'Name')->sort()->filter(),
            TD::make('actions', __('Actions'))->render(function (CarBrand $model) {
                return DropDown::make()
                    ->icon('options-vertical')
                    ->list([
                        ModalToggle::make(__('Edit'))->modal('edit')->method('update')->icon('pencil')->modalTitle(__('Edit brand №') . $model->id)->asyncParameters(['model' => $model->id]),
                        Button::make(__('Remove'))->icon('trash')->confirm(__('Are you sure?'))->method('remove', [
                            'id' => $model->id
                        ]),
                    ]);
            })
        ];
    }
}
