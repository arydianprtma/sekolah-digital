<?php

namespace App\Filament\Resources\Schedules;

use App\Filament\Resources\Schedules\Pages\CreateSchedule;
use App\Filament\Resources\Schedules\Pages\EditSchedule;
use App\Filament\Resources\Schedules\Pages\ListSchedules;
use App\Filament\Resources\Schedules\Schemas\ScheduleForm;
use App\Filament\Resources\Schedules\Tables\SchedulesTable;
use App\Models\Schedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ScheduleResource extends Resource
{
    use \App\Filament\Traits\HasRoleVisibility;

    protected static array $allowedRoles = ['admin', 'guru', 'siswa', 'orang_tua'];

    protected static ?string $model = Schedule::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static \UnitEnum|string|null $navigationGroup = 'Akademik & Sekolah';

    protected static ?string $parentItem = 'Manajemen Akademik';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Jadwal Pelajaran';

    protected static ?string $modelLabel = 'Jadwal Pelajaran';

    protected static ?string $pluralModelLabel = 'Jadwal Pelajaran';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return ScheduleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SchedulesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user && $user->hasRole('guru') && !$user->hasRole('admin') && !$user->hasRole('Super Admin')) {
            $teacherId = $user->teacherStaff?->id;
            if ($teacherId) {
                $query->where('teacher_id', $teacherId);
            }
        } elseif ($user && $user->hasRole('siswa') && !$user->hasRole('admin') && !$user->hasRole('Super Admin')) {
            $classroomId = $user->student?->classroom_id;
            if ($classroomId) {
                $query->where('classroom_id', $classroomId);
            }
        } elseif ($user && $user->hasRole('orang_tua') && !$user->hasRole('admin') && !$user->hasRole('Super Admin')) {
            $studentIds = \App\Models\StudentParent::where('user_id', $user->id)->pluck('student_id');
            $classroomIds = \App\Models\Student::whereIn('id', $studentIds)->pluck('classroom_id');
            $query->whereIn('classroom_id', $classroomIds);
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSchedules::route('/'),
            'create' => CreateSchedule::route('/create'),
            'edit' => EditSchedule::route('/{record}/edit'),
        ];
    }
}
