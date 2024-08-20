<?php

namespace App\Queries;

class ProductFilter extends QueryFilter
{
  public function rules(): array
  {
    return [
			'search' => 'filled',
      'at1' => 'filled', 'at2' => 'filled', 'at3' => 'filled', 'at4' => 'filled', 'at5' => 'filled',
      'at6' => 'filled', 'at7' => 'filled', 'at8' => 'filled', 'at9' => 'filled', 'at10' => 'filled',
      'at11' => 'filled', 'at12' => 'filled', 'at13' => 'filled', 'at14' => 'filled', 'at15' => 'filled',
      'at16' => 'filled', 'at17' => 'filled', 'at18' => 'filled', 'at19' => 'filled', 'at20' => 'filled',
      'at21' => 'filled', 'at22' => 'filled', 'at23' => 'filled', 'at24' => 'filled', 'at25' => 'filled',
      'at26' => 'filled', 'at27' => 'filled', 'at28' => 'filled', 'at29' => 'filled', 'at30' => 'filled',
		];
	}

  public function search($query, $search)
  {
		if(empty($search)) {
			return $query;
    }

    return $query->where(function ($query) use ($search) {
      $query->where('ref', 'like', "%{$search}%")
            ->where('label', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    });
	}

  public function at1($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at1', '=', $value);
    });
  }

  public function at2($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at2', '=', $value);
    });
  }

  public function at3($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at3', '=', $value);
    });
  }

  public function at4($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at4', '=', $value);
    });
  }

  public function at5($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at5', '=', $value);
    });
  }

  public function at6($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at6', '=', $value);
    });
  }

  public function at7($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at7', '=', $value);
    });
  }

  public function at8($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at8', '=', $value);
    });
  }

  public function at9($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at9', '=', $value);
    });
  }

  public function at10($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at10', '=', $value);
    });
  }

  public function at11($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at11', '=', $value);
    });
  }

  public function at12($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at12', '=', $value);
    });
  }

  public function at13($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at13', '=', $value);
    });
  }

  public function at14($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at14', '=', $value);
    });
  }

  public function at15($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at15', '=', $value);
    });
  }

  public function at16($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at16', '=', $value);
    });
  }

  public function at17($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at17', '=', $value);
    });
  }

  public function at18($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at18', '=', $value);
    });
  }

  public function at19($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at19', '=', $value);
    });
  }

  public function at20($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at20', '=', $value);
    });
  }

  public function at21($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at21', '=', $value);
    });
  }

  public function at22($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at22', '=', $value);
    });
  }

  public function at23($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at23', '=', $value);
    });
  }

  public function at24($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at24', '=', $value);
    });
  }

  public function at25($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at25', '=', $value);
    });
  }

  public function at26($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at26', '=', $value);
    });
  }

  public function at27($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at27', '=', $value);
    });
  }

  public function at28($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at28', '=', $value);
    });
  }

  public function at29($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at29', '=', $value);
    });
  }

  public function at30($query, $value)
  {
    if(empty($value)) { return $query; }

    return $query->whereHas('extrafields', function ($query) use ($value) {
      $query->where('at30', '=', $value);
    });
  }
}