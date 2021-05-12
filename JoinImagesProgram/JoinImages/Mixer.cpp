#include "Mixer.h"
#define cimg_use_jpeg
#include <CImg.h>

Mixer::Mixer(char* ModelImageURL, char* PhotoImageURL)
{
	using namespace cimg_library;
	/*CImg<unsigned char> gradient("gradient.png");
	CImg<unsigned char> overlay("overlay.png");
	gradient.draw_image(150, 50, overlay);
	gradient.save_png("result.png");*/
	CImg<unsigned char> Model(ModelImageURL);
	CImg<unsigned char> ImageRef(PhotoImageURL);
	Model.draw_image(150, 50, ImageRef);
	Model.save("C:\\Users\\ricar\\Desktop\\SiteGiu\\JoinImagesProgram\\JoinImages\\result.jpeg");
}