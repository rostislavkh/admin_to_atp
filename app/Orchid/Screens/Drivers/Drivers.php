<?php

namespace App\Orchid\Screens\Drivers;

use Carbon\Carbon;
use App\Models\Driver;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Bus;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Actions\ModalToggle;
use App\Http\Requests\CreateDriverStore;
use App\Http\Requests\UpdateDriverStore;
use App\Jobs\SendEmailToDriverLaterDayJob;

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
                Upload::make('attachment')->title('Image (file)')->maxFiles(1)->acceptedFiles('image/*'),
                Input::make('src_img')->title('Image link'),
                Input::make('email')->title('Email')->type('email')->required(),
                Input::make('salary')->title('Salary')->min(3)->max(100)->required(),
                Input::make('first_name')->title('First name')->min(3)->max(100)->required(),
                Input::make('last_name')->title('Last name')->min(3)->max(100)->required(),
                DateTimer::make('birthday')->title('Birthday')->allowInput()->format('Y-m-d')->required()
            ])),
            Layout::modal('edit', Layout::rows([
                Upload::make('model.attachment')->title('Image (file)')->maxFiles(1)->acceptedFiles('image/*'),
                Input::make('model.src_img')->title('Image link'),
                Input::make('model.email')->title('Email')->type('email')->required(),
                Input::make('model.salary')->title('Salary')->min(3)->max(100)->required(),
                Input::make('model.first_name')->title('First name')->min(3)->max(100)->required(),
                Input::make('model.last_name')->title('Last name')->min(3)->max(100)->required(),
                DateTimer::make('model.birthday')->title('Birthday')->allowInput()->format('Y-m-d')->required()
            ]))->async('asyncGetModel'),
            \App\Orchid\Layouts\Drivers\Drivers::class
        ];
    }

    public function asyncGetModel(\App\Models\Driver $model): array
    {
        $model->load('attachment');

        return [
            'model' => $model
        ];
    }

    public function create(CreateDriverStore $request)
    {
        $driver = Driver::create([
            'src_img' => $request->src_img,
            'first_name' => strtolower($request->first_name),
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'email' => $request->email,
            'salary' => $request->salary
        ]);

        $driver->load('attachment');

        $driver->attachment()->syncWithoutDetaching(
            $request->input('attachment', [])
        );

        Toast::success(__('Driver was created'));
    }

    public function update(\App\Models\Driver $model, UpdateDriverStore $request)
    {
        $model->update([
            'src_img' => \Illuminate\Support\Arr::get($request->model, 'src_img', null),
            'first_name' => strtolower(\Illuminate\Support\Arr::get($request->model, 'first_name', 'No name')),
            'last_name' => \Illuminate\Support\Arr::get($request->model, 'last_name', 'No name'),
            'birthday' => \Illuminate\Support\Arr::get($request->model, 'birthday', 'No birthday'),
            'email' => \Illuminate\Support\Arr::get($request->model, 'email', 'No email'),
            'salary' => \Illuminate\Support\Arr::get($request->model, 'salary', 0)
        ]);

        $model->attachment()->syncWithoutDetaching(
            $request->input('model.attachment', [])
        );

        Toast::success(__('Driver was updated'));
    }

    public function remove(Request $request)
    {
        $driver = \App\Models\Driver::find($request->id);

        if ($driver->email) {
            dispatch(new SendEmailToDriverLaterDayJob($driver->email, $driver->last_name));
        }

        $driver->delete();

        Toast::success(__('Driver was removed'));
    }
}
