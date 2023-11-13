2022 novemberi megoldás, a Szerveroldali webprogramozás kurzus beadandója.
Használt technológiák: Laravel, Tailwind CSS

## Oldal leírása
Egy múzeum oldala, ahol a kiállított tárgyakat lehet megtekinteni, hozzászólást írni.
Az adminnak (admin@pcmuseum.hu/admin) joga van új tárgyakat és címkéket létrehozni, ezeket módosítani.
Többi felhasználó megtekintheti, illetve megjegyzéseket fűzhet a kiállított darabokhoz.

## Futtatás

```init.bat``` vagy ```init.sh``` futtatása beállítja, majd elindíja a szervert.

_Sok címke generálása miatt megeshet hogy azonos nevűek kerülnének az adatbázisba, ekkor hibát dob. Adatok újragenerálása: ```php artisan migrate:fresh --seed```_

## Képek az oldalról
Kezdőlap
![museum-index](https://github.com/SabianRobi/BackendWebProg-assignment/assets/101527023/369a2c79-e051-40bc-bf3e-1000712cbf6d)

Kiállított tárgy
![museum-item](https://github.com/SabianRobi/BackendWebProg-assignment/assets/101527023/756f79af-41b6-4dda-8767-7e2198f08d91)

Szűrés címke szerint
![museum-label-items](https://github.com/SabianRobi/BackendWebProg-assignment/assets/101527023/4611cfcf-038b-4f55-b218-c6098246ed1f)

Új tárgy hozzáadása
![museum-add-item](https://github.com/SabianRobi/BackendWebProg-assignment/assets/101527023/8b402e8c-1f23-4a55-af24-5c82975d35a1)
