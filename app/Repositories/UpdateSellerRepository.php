<?php

namespace App\Repositories;

class UpdateSellerRepository
{
	public function execute($seller)
	{
		$this->addInputs($seller, ['name', 'email', 'about', 'address', 'shipping', 'city_id']);

		$this->addImage($seller);
		
		$seller->edit_status = 1;
		$seller->save();
	}

	protected function addInputs(&$seller, $array)
	{
		foreach ($array as $value)
		{
			if (request()->filled($value)) {
				$seller['new_' . $value] = request()->{$value};
			}
		}
	}

	protected function addImage(&$seller)
	{
		if (request()->hasFile('image') && !empty(request()->file('image'))) {
            $destination = public_path('seller_assets/users/');

            // delete old image
            if ($seller->image && file_exists($destination . $seller->image)) {
            	unlink($destination . $seller->image);
            }
            
            // add new
            $image = request()->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move($destination, $name);

            $seller->image = $name;
        }
	}	
}