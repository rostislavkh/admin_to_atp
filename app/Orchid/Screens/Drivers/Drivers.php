<?php

namespace App\Orchid\Screens\Drivers;

use App\Http\Requests\CreateDriverStore;
use App\Http\Requests\UpdateDriverStore;
use App\Models\Driver;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Actions\ModalToggle;

class Drivers extends Screen
{
    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.drivers',
        ];
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'drivers' => Driver::filters()
                ->defaultSort('id', 'desc')
                ->paginate(25)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Drivers';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make(__('Create'))->icon('plus')->modal('create')->modalTitle(__('Create driver'))->method('create')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::modal('create', Layout::rows([
                Input::make('src_img')->title('Image link'),
                Input::make('first_name')->title('First name')->min(3)->max(100)->required(),
                Input::make('last_name')->title('Last name')->min(3)->max(100)->required(),
                DateTimer::make('birthday')->title('Birthday')->allowInput()->format('Y-m-d')->required()
            ])),
            Layout::modal('edit', Layout::rows([
                Input::make('model.src_img')->title('Image link'),
                Input::make('model.first_name')->title('First name')->min(3)->max(100)->required(),
                Input::make('model.last_name')->title('Last name')->min(3)->max(100)->required(),
                DateTimer::make('model.birthday')->title('Birthday')->allowInput()->format('Y-m-d')->required()
            ]))->async('asyncGetModel'),
            \App\Orchid\Layouts\Drivers\Drivers::class
        ];
    }

    public function asyncGetModel(\App\Models\Driver $model): array
    {
        return [
            'model' => $model
        ];
    }

    public function create(CreateDriverStore $request)
    {
        Driver::create([
            'src_img' => $request->src_img,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday
        ]);

        Toast::success(__('Driver was created'));
    }

    public function update(\App\Models\Driver $model, UpdateDriverStore $request)
    {
        $model->update([
            'src_img' => \Illuminate\Support\Arr::get($request->model, 'src_img', null),
            'first_name' => \Illuminate\Support\Arr::get($request->model, 'first_name', 'No name'),
            'last_name' => \Illuminate\Support\Arr::get($request->model, 'last_name', 'No name'),
            'birthday' => \Illuminate\Support\Arr::get($request->model, 'birthday', 'No birthday')
        ]);

        Toast::success(__('Driver was updated'));
    }

    public function remove(Request $request)
    {
        \App\Models\CarBrand::find($request->id)->delete();

        Toast::success(__('Driver was removed'));
    }
}
