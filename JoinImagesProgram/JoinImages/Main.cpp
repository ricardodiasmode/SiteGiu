#include "Mixer.h"
#include <iostream>

int main()
{
	std::cout << "Running Mixer..." << std::endl;
	char AuxCharModelo[100] = "C:\\Users\\ricar\\Desktop\\SiteGiu\\JoinImagesProgram\\JoinImages\\Modelo1Separado.jpeg\0";
	char AuxCharPhoto[100] = "C:\\Users\\ricar\\Desktop\\SiteGiu\\JoinImagesProgram\\JoinImages\\20151017_155833.jpeg\0";
	Mixer(AuxCharModelo, AuxCharPhoto);
	return 0;
}