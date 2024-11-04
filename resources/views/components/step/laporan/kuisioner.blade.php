<div class="min-h-2 space-y-2">
    <h3 class="text-lg font-semibold" id="kuisioner">Kuisioner</h3>

    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse whitespace-nowrap border border-zinc-50 pb-8 text-left">
            <thead class="uppercase">
                <tr>
                    <th class="border border-zinc-100 px-2 py-2">No</th>
                    <th class="border border-zinc-100 px-2 py-2">Komponen Penilaian</th>
                    <th class="border border-zinc-100 px-2 py-2">Sangat Setuju</th>
                    <th class="border border-zinc-100 px-2 py-2">Setuju</th>
                    <th class="border border-zinc-100 px-2 py-2">Tidak Setuju</th>
                    <th class="border border-zinc-100 px-2 py-2">Sangat Tidak Setuju</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i < 10; $i++)
                    <tr class="align-top odd:bg-zinc-50 even:bg-white">
                        <td class="border border-zinc-100 px-2 py-2">{{ $i }}</td>
                        <td class="text-wrap border border-zinc-100 px-2 py-2">
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Perferendis officiis dolorem
                            eveniet illum, soluta amet? Minima quos corporis, aliquam beatae at cupiditate maxime
                            facere, aliquid sapiente vel rerum, reiciendis incidunt?
                        </td>
                        <td class="border border-zinc-100 px-2 py-2">80%</td>
                        <td class="border border-zinc-100 px-2 py-2">80%</td>
                        <td class="border border-zinc-100 px-2 py-2">80</td>
                        <td class="border border-zinc-100 px-2 py-2">80</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
