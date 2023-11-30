<div class="mx-auto max-w-7xl my-2 p-2 border rounded shadown bg-white relative">
    @if ($err_bool)
        <div class="absolute w-full h-full bg-slate-200/50 flex justify-center items-center">
            <div class="w-96 bg-white h-96 p-2 rounded-xl relative">
                <p class="flex justify-center items-center text-xl uppercase text-red-600">Ha ocurrido un error</p>
                <div class="text-justify m-2 border-red-400">
                    <span class="text-red-600">Mensaje: {{ $msg }}</span>
                    <p class="py-4 text-yellow-400">CODIGO DE ERROR: {{$err}}</p>
                </div>
                <div class="absolute bottom-0 flex justify-center items-center w-full">
                    <button class="bg-yellow-500 px-3 py-2 uppercase rounded text-white" wire:click="closeError">Cerrar</button>
                </div>
            </div>
        </div>
    @endif
    <div class="flex justify-center items-center text-2xl uppercase border-b">
        <h2>Moldeo científico</h2>
    </div>
    <div class="grid grid-cols-6 lg:grid-cols-12 p-2" wire:target="oh">
        <form wire:submit.prevent="calculate" class="col-span-full lg:col-span-6 border shadow-sm p-2">
            <p>Datos necesarios:</p>
            <ul class="list-decimal pl-4 divide-y divi">
                <li class="flex justify-between gap-2 min-w-fit flex-wrap">
                    <span>Diametro husillo (Øh): {{ $oh ? $oh . 'mm' : 'N/A' }}</span>
                    <input required wire:model.defer="oh" class="rounded text-sm min-w-fit w-72" type="number"
                        step="0.01" placeholder="ingrese el diametro en milimetros">
                </li>
                <li class="flex justify-between gap-2 min-w-fit flex-wrap">
                    <span>Carrera maxima de carga (CMC):{{ $cmc ? $cmc . 'mm' : 'N/A' }}</span>
                    <input required wire:model="cmc" class="rounded text-sm min-w-fit w-72" type="number"
                        step="0.01" placeholder="Ingrese el CMC en milimetros">
                </li>
                <li class="flex justify-between gap-2 min-w-fit flex-wrap">
                    <span>Masa (m):{{ $m ? $m . 'g' : 'N/A' }}</span>
                    <input required wire:model="m" class="rounded text-sm min-w-fit w-72" type="number" step="0.01"
                        placeholder="Ingrese la masa en gramos">
                </li>
                <li class="flex justify-between gap-2 min-w-fit flex-wrap">
                    <span>Melt Density(ρm)³: {{ $pm ? $pm . 'g/cm³' : 'N/A' }}</span>
                    <input required wire:model="pm" class="rounded text-sm min-w-fit w-72" type="number" step="0.01"
                        placeholder="Ingrese el melt density gramos/cm³ ">
                </li>
            </ul>
            <div class="col-span-full p-2">
                <button
                    class="flex justify-center tex-xs w-full px-2 bg-green-500 text-white uppercase">Calcular</button>
            </div>
        </form>
        <div class="col-span-full lg:col-span-6 border shadow-sm p-2">
            <p>Resultados:</p>

            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                            <table class="min-w-full text-left text-sm font-light">
                                <thead class="border-b font-medium dark:border-neutral-500">
                                    <tr>
                                        <th scope="col" class="px-6 py-4">#IDENTIFICADOR</th>
                                        <th scope="col" class="px-6 py-4">CM</th>
                                        <th scope="col" class="px-6 py-4">MM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b dark:border-neutral-500">
                                        <td class="whitespace-nowrap px-6 py-4">VMC</td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ $vmc ? $vmc : 'N/A' }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            {{ $vmc ? $this->convertToMm($vmc) : 'N/A' }}</td>
                                    </tr>
                                    <tr class="border-b dark:border-neutral-500">
                                        <td class="whitespace-nowrap px-6 py-4">VD</td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ $vd ? $vd : 'N/A' }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            {{ $vd ? $this->convertToMm($vd) : 'N/A' }}</td>
                                    </tr>
                                    <tr class="border-b dark:border-neutral-500">
                                        <td class="whitespace-nowrap px-6 py-4">TD</td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ $td ? $td : 'N/A' }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            {{ $td ? $this->convertToMm($td) : 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </table>
        </div>
    </div>

    <div class="flex justify-center p-2 mx-auto border-t">
        <span>Cálculo usando densidad</span>
    </div>


    <div class="grid grid-cols-6 lg:grid-cols-12">

        <form wire:submit.prevent="calculate_v2" class="col-span-full lg:col-span-6 border shadow-sm p-2">
            <p>Datos necesarios:</p>
            <ul class="list-decimal pl-4 divide-y divi">
                <li class="flex justify-between gap-2 min-w-fit flex-wrap">
                    <span>Diametro husillo: {{ $diametroTornillo ? $diametroTornillo . 'mm' : 'N/A' }}</span>
                    <input required wire:model.defer="diametroTornillo" class="rounded text-sm min-w-fit w-72"
                        type="number" step="0.01" placeholder="ingrese el diametro en milimetros">
                </li>
                <li class="flex justify-between gap-2 min-w-fit flex-wrap">
                    <span>Pocicion de maxima
                        recarga:{{ $posicionMaximaRecarga ? $posicionMaximaRecarga . 'mm' : 'N/A' }}</span>
                    <input required wire:model="posicionMaximaRecarga" class="rounded text-sm min-w-fit w-72"
                        type="number" step="0.01" placeholder="Ingrese el CMC en milimetros">
                </li>
                <li class="flex justify-between gap-2 min-w-fit flex-wrap">
                    <span>Densidad de material:{{ $densidadMaterial ? $densidadMaterial . 'g' : 'N/A' }}</span>
                    <input required wire:model="densidadMaterial" class="rounded text-sm min-w-fit w-72" type="number"
                        step="0.01" placeholder="Ingrese la masa en gramos">
                </li>
            </ul>
            <div class="col-span-full p-2">
                <button
                    class="flex justify-center tex-xs w-full px-2 bg-green-500 text-white uppercase">Calcular</button>
            </div>
        </form>
        <div class="col-span-full lg:col-span-6 border shadow-sm p-2">
            Resultado:
            {{ $resultado ? $resultado : 'N\A' }}
        </div>
    </div>



    <div class="flex justify-center p-2 mx-auto border-t">
        <span>Cálculo tamaño de disparo (material) </span>
    </div>


    <div class="grid grid-cols-6 lg:grid-cols-12">

        <form wire:submit.prevent="CalculateV3" class="col-span-full lg:col-span-6 border shadow-sm p-2">
            <p>Datos necesarios:</p>
            <ul class="list-decimal pl-4 divide-y divi">
                <li class="flex justify-between gap-2 min-w-fit flex-wrap">
                    <span>Volumen teorico: {{ $vt ? $vt . 'mm' : 'N/A' }}</span>
                    <input required wire:model.defer="vt" class="rounded text-sm min-w-fit w-72" type="number"
                        step="0.01" placeholder="ingrese el volumen teorico en mm">
                </li>
                <li class="flex justify-between gap-2 min-w-fit flex-wrap">
                    <span>Dencidad del material: {{ $dm ? $dm : 'N/A' }}</span>
                    <input required wire:model.defer="dm" class="rounded text-sm min-w-fit w-72" type="number"
                        step="0.01" placeholder="ingrese el dencidad del material">
                </li>
                <li class="flex justify-between gap-2 min-w-fit flex-wrap">
                    <span>Peso en gramos de pieza: {{ $pgp ? $pgp . 'g' : 'N/A' }}</span>
                    <input required wire:model.defer="pgp" class="rounded text-sm min-w-fit w-72" type="number"
                        step="0.01" placeholder="ingrese el peso en gramos de la pieza">
                </li>
                <li class="flex justify-between gap-2 min-w-fit flex-wrap">
                    <span>Valor maximo de maquina: {{ $vmm ? $vmm . 'mm' : 'N/A' }}</span>
                    <input required wire:model.defer="vmm" class="rounded text-sm min-w-fit w-72" type="number"
                        step="0.01" placeholder="ingrese el valor maximo de maquina en mm">
                </li>
            </ul>
            <div class="col-span-full p-2">
                <button
                    class="flex justify-center tex-xs w-full px-2 bg-green-500 text-white uppercase">Calcular</button>
            </div>
        </form>
        <div class="col-span-full lg:col-span-6 border shadow-sm p-2">
            Resultados
            <p class="flex gap-2 justify-between uppercase border py-2 px-3">
                <span>Resultado pgr:</span>
                {{ $pgr ? $pgr : 'N\A' }}
            </p>
            <p class="flex gap-2 justify-between uppercase border py-2 px-3">
                <span>Resultado regular</span>
                {{ $resv3 ? $resv3 : 'N\A' }}
            </p>
            <p class="flex gap-2 justify-between uppercase border py-2 px-3">
                <span>Resultado margen - 100</span>
                {{ $resv3_1 ? $resv3_1 : 'N\A' }}
            </p>
            <p class="flex gap-2 justify-between uppercase border py-2 px-3">
                <span>Resultado margen + 100</span>
                {{ $resv3_2 ? $resv3_2 : 'N\A' }}
            </p>
        </div>
    </div>
</div>
