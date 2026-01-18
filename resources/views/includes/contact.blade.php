<section class="sm:px-16 sm:py-16 px-6 py-10 text-white max-w-7xl mx-auto relative z-0">
    <span id="contact" class="hash-span">&nbsp;</span>
    <div class="xl:mt-12 xl:flex-row flex-col-reverse flex gap-10 overflow-clip">
        <div class="flex-[0.75] p-8 rounded-2xl bg-black-100 z-10"
            style="transform: translateX(0%) translateY(0px) translateZ(0px);">
            <p class="sm:text-[18px] text-white text-[14px] text-secondary tracking-wider uppercase"">I would love to hear from you</p>
            <h3 class=" text-white font-black md:text-[60px] sm:text:[-50px] xs:text-[40px] text-[30px] ">Contact.</h3>
            <form action=" {{route('enquiry.store') }}" method="post" class="mt-12 flex flex-col gap-8">
                {{ csrf_field()}}
                
                <label for="name" class="flex flex-col">
                    <span class="text-white font-medium mb-4">Your Name</span>
                    <input type="text" class="bg-tertiary py-4 px-6 outline-none border-none" name="name"
                        placeholder="Your Name" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </label>

                <label for="email" class="flex flex-col">
                    <span class="text-white font-medium mb-4">Your Email</span>
                    <input type="email" class="bg-tertiary py-4 px-6 outline-none border-none" name="email" id="email"
                        placeholder="Your Email" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </label>

                <label for="message" class="flex flex-col">
                    <span class="text-white font-medium mb-4">Your Message</span>
                    <textarea
                        class="bg-tertiary py-4 px-6 placeholder:text-secondary text-white rounded-lg outline-none border-none font-medium"
                        name="message" id="" placeholder="Type your message" rows="7"></textarea>
                    @error('message')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </label>

                <button
                    class="bg-tertiary py-3 px-8 outline-none w-fit font-bold text-white shadow-md shadow-primary rounded-xl">Send</button>

                </form>

        </div>
        <div class="xl:flex-1 xl:h-auto md:h-[550px] h-[350px] z-[20]"
            style="transform: translateX(0%) translateY(0px) translateZ(0px);">
            <div style="position: relative; width: 100%; height: 100%; overflow: hidden; pointer-events: auto; touch-action: none;"
                shadowsframeloop="demand">
                <div style="width: 100%; height: 100%;"><canvas style="display: block; width: 598.85px; height: 805px;"
                        data-engine="three.js r150" width="598" height="805"></canvas></div>
            </div>
        </div>

    </div>

</section>