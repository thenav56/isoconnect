<?php

class Photo extends \Eloquent {
	protected $fillable = ['user_id' , 'location' , 'source_id','source_type'];

	

	public static function image($id, $field = null , $_field = null){

		if(!$field){
			$img = Image::make('store/photo/lowsize_image/default.png') ;
			return $img->resize(100,100)->response('jpg');
		}

		switch ($field) {
			case 'profile':
				switch ($_field) {
					case 'original':
						$photo = Photo::find($id);
							//if not found or not 'profile' then default
							if(!($photo->source_type == 'profile')){
								$img = Image::make('store/photo/lowsize_image/default.png') ;
								return $img->resize(100,100)->response('jpg');
							}
						$profile_pic = Image::make('store/photo/original/'.$photo->location);
						return $profile_pic->response('jpg');


						break;
					
					default:
						$photo = Photo::find($id);
							//if not found then default
							if(!($photo->source_type == 'profile')){
								$img = Image::make('store/photo/lowsize_image/default.png') ;
								return $img->resize(100,100)->response('jpg');
							}
						$profile_pic = Image::make('store/photo/lowsize_image/'.$photo->location);
						//other filter here for croping image
						return $profile_pic->resize(100,100)->response('jpg');
						break;
				}
				break;
			
			case 'post':
				switch ($_field) {
					case 'original':
						$photo = Photo::find($id);
							//if not found or not 'profile' then default
							if(!($photo->source_type == 'post')){
								$img = Image::make('store/photo/lowsize_image/default.png') ;
								return $img->resize(100,100)->response('jpg');
							}
						$post_pic = Image::make('store/photo/original/'.$photo->location);
						return $post_pic->response('jpg');


						break;
					
					default:
						$photo = Photo::find($id);
							//if not found then default
							if(!($photo->source_type == 'post')){
								$img = Image::make('store/photo/lowsize_image/default.png') ;
								return $img->resize(100,100)->response('jpg');
							}
						$post_pic = Image::make('store/photo/lowsize_image/'.$photo->location);
						//other filter here for croping image
						return $post_pic->resize(100,100)->response('jpg');
						break;
				}
				break;
	

			case 'user_photo':
				switch ($_field) {
					case 'original':
						$photo = Photo::find($id);
							//if not found or not 'profile' then default
							if(!($photo->source_type == 'user_photo')){
								$img = Image::make('store/photo/lowsize_image/default.png') ;
								return $img->resize(100,100)->response('jpg');
							}
						$post_pic = Image::make('store/photo/original/'.$photo->location);
						return $post_pic->response('jpg');


						break;
					
					default:
						$photo = Photo::find($id);
							//if not found then default
							if(!($photo->source_type == 'user_photo')){
								$img = Image::make('store/photo/lowsize_image/default.png') ;
								return $img->resize(100,100)->response('jpg');
							}
						$post_pic = Image::make('store/photo/lowsize_image/'.$photo->location);
						//other filter here for croping image
						return $post_pic->resize(100,100)->response('jpg');
						break;
				}
				break;
		}
			//by default ...default image
			$img = Image::make('store/photo/lowsize_image/default.png') ;
			return $img->resize(100,100)->response('jpg');

	}
}