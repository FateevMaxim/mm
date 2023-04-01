<?php

namespace App\Exports;

use App\Models\City;
use App\Models\TrackList;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{

    use Importable;
    private $date;
    private $city;

    public function __construct(string|null $date, string $city)
    {
        $this->date = $date;
        $this->city = $city;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = TrackList::query()
            ->select('id', 'track_code', 'status', 'city');
        if ($this->date != null){
            $query->whereDate('to_client', $this->date);
        }
        if ($this->city != 'Выберите город'){
            $query->where('city', 'LIKE', $this->city);
        }

        return $query->with('user')->get();
    }
    public function headings(): array
    {
        return [
            '#',
            'Трек код',
            'ФИО',
        ];
    }
}
