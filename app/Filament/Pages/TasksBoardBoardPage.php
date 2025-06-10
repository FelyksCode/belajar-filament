<?php

namespace App\Filament\Pages;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Relaticle\Flowforge\Filament\Pages\KanbanBoardPage;
use Filament\Actions\Action;
use Filament\Forms;

class TasksBoardBoardPage extends KanbanBoardPage
{
    protected static ?string $navigationIcon = 'heroicon-o-view-columns';
    protected static ?string $navigationLabel = 'Tasks Board Page';
    protected static ?string $title = 'Kanban Task Board';

    public function getSubject(): Builder
    {
        return Task::query();
    }

    public function mount(): void
    {
        $this
            ->titleField('title')
            ->columnField('status')
            ->columns(TaskStatus::getColumns())
            ->columnColors(TaskStatus::getColumnColors())
            ->descriptionField('description')
            ->orderField('order_column')
            ->cardLabel('Task')
            ->pluralCardLabel('Tasks')
            ->cardAttributes([
                'due_date' => 'Due Date',
                'user.name' => 'Created By',
            ])
            ->cardAttributeColors([
                'due_date' => 'yellow',
                'user.name' => 'blue',
            ])
            ->cardAttributeIcons([
                'due_date' => 'heroicon-o-calendar',
                'user.name' => 'heroicon-o-user',
            ])
        ;
    }


    public function createAction(Action $action): Action
    {
        return $action
            ->iconButton()
            ->icon('heroicon-o-plus')
            ->modalHeading('Create Task')
            ->modalWidth('xl')
            ->form(function (Forms\Form $form) {
                return $form->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->placeholder('Enter task title')
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('description')
                        ->columnSpanFull(),
                    Forms\Components\DatePicker::make('due_date')
                        ->label('Due Date')
                        ->columnSpanFull(),
                    Forms\Components\Hidden::make('user_id')
                        ->default(auth()->id()),
                ]);
            });
    }

    public function editAction(Action $action): Action
    {
        return $action
            ->modalHeading('Edit Task')
            ->modalWidth('xl')
            ->form(function (Forms\Form $form) {
                return $form->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->placeholder('Enter task title')
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('description')
                        ->columnSpanFull(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'todo' => 'To Do',
                            'in_progress' => 'In Progress',
                            'completed' => 'Completed',
                        ])
                        ->required(),
                    Forms\Components\DatePicker::make('due_date')
                        ->label('Due Date')
                        ->columnSpanFull(),
                    Forms\Components\Hidden::make('user_id')
                        ->default(auth()->id()),
                ]);
            });
    }
}
