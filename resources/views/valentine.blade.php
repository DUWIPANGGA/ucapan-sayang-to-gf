<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>For {{ $valentine->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{--r:30px;--bg:#060010;--red:#ef4444;--pink:#ec4899;--pf:'Playfair Display',serif;--sans:'Inter',sans-serif;}
        *{margin:0;padding:0;box-sizing:border-box;}
        html,body{font-family:var(--sans);background:var(--bg);color:#fff;overflow-x:hidden;width:100%;min-height:100dvh;}
        .hidden{display:none!important;}

        /* Flow */
        #flow{position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;background:var(--bg);overflow:hidden;}
        .bg-r{position:absolute;inset:0;background:radial-gradient(circle at center,rgba(239,68,68,0.15) 0%,transparent 70%);}
        .bg-c{position:absolute;inset:0;opacity:0.08;background-image:url("data:image/svg+xml,%3Csvg width='6' height='6' viewBox='0 0 6 6' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.15'%3E%3Cpath d='M5 0h1L0 6V5zM6 5v1H5z'/%3E%3C/g%3E%3C/svg%3E");}
        .crn{position:absolute;border-radius:50%;filter:blur(100px);pointer-events:none;}
        .cr-tl{width:min(24rem,60vw);height:min(24rem,60vw);top:-6rem;left:-6rem;background:rgba(127,29,29,0.25);}
        .cr-br{width:min(24rem,60vw);height:min(24rem,60vw);bottom:-6rem;right:-6rem;background:rgba(136,19,55,0.25);}

        /* Floating Items */
        #floaters{position:absolute;inset:0;overflow:hidden;pointer-events:none;z-index:1;}
        .floater{position:absolute;pointer-events:none;animation:floatUp linear infinite;}
        .floater svg{opacity:0.15;}
        @keyframes floatUp{
            0%{opacity:0;transform:translateY(110vh) rotate(0deg) scale(0.6);}
            8%{opacity:1;}
            92%{opacity:1;}
            100%{opacity:0;transform:translateY(-10vh) rotate(var(--rot,180deg)) scale(var(--s,0.6));}
        }

        /* Steps */
        .step{transition:opacity 0.4s ease,transform 0.4s ease;}
        .step.out{opacity:0;transform:scale(0.95);filter:blur(10px);}

        /* Step 1 - Love Mode */
        .love-card{
            backdrop-filter:blur(40px);-webkit-backdrop-filter:blur(40px);
            padding:clamp(1.5rem,5vw,3rem);border-radius:clamp(1.5rem,5vw,3rem);
            transition:all 1s ease;display:flex;flex-direction:column;align-items:center;gap:clamp(1.5rem,4vw,2.5rem);
            border:1px solid rgba(255,255,255,0.1);background:rgba(255,255,255,0.05);
            box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);
            width:clamp(280px,85vw,400px);
        }
        .love-card.on{background:rgba(239,68,68,0.1);box-shadow:0 0 80px rgba(239,68,68,0.2);border-color:rgba(239,68,68,0.2);}

        .heart-ico{width:clamp(4rem,12vw,6rem);height:clamp(4rem,12vw,6rem);transition:all 1s ease;color:rgba(255,255,255,0.1);fill:none;}
        .heart-ico.on{color:var(--red);fill:var(--red);animation:pulse 2s ease-in-out infinite;}
        @keyframes pulse{0%,100%{transform:scale(1);filter:drop-shadow(0 0 0 rgba(239,68,68,0));}50%{transform:scale(1.15);filter:drop-shadow(0 0 20px rgba(239,68,68,0.6));}}

        .love-txt{font-family:var(--pf);font-size:clamp(2rem,6vw,3rem);transition:color 1s ease;display:block;margin-bottom:1rem;color:rgba(255,255,255,0.4);text-align:center;}
        .love-txt.on{color:#fff;}

        /* Toggle Button - Premium Style */
        .tgl{
            position:relative;width:clamp(70px,20vw,90px);height:clamp(38px,10vw,48px);
            border-radius:9999px;border:none;cursor:pointer;padding:4px;outline:none;
            background:rgba(255,255,255,0.12);
            transition:all 0.5s cubic-bezier(0.23,1,0.32,1);
            box-shadow:inset 0 2px 4px rgba(0,0,0,0.2);
        }
        .tgl.on{background:linear-gradient(135deg,var(--red),var(--pink));box-shadow:0 0 30px rgba(239,68,68,0.5),inset 0 2px 4px rgba(0,0,0,0.1);}

        .tgl-knob{
            position:absolute;top:4px;left:4px;
            width:calc(clamp(38px,10vw,48px) - 4px);height:calc(clamp(38px,10vw,48px) - 4px);
            background:#fff;border-radius:50%;
            box-shadow:0 2px 8px rgba(0,0,0,0.3),0 0 0 2px rgba(255,255,255,0.1);
            transition:all 0.4s cubic-bezier(0.34,1.56,0.64,1);
            display:flex;align-items:center;justify-content:center;
            z-index:2;
        }
        .tgl.on .tgl-knob{transform:translateX(clamp(32px,10vw,42px));}
        .tgl-knob svg{width:18px;height:18px;transition:all 0.4s ease;}

        .tgl-label{
            position:absolute;top:0;left:0;right:0;bottom:0;
            display:flex;align-items:center;justify-content:center;
            font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.15em;
            pointer-events:none;z-index:1;
        }
        .tgl-label .lbl-off{
            position:absolute;left:clamp(10px,3vw,14px);
            color:rgba(255,255,255,0.5);transition:all 0.3s ease;
        }
        .tgl-label .lbl-on{
            position:absolute;right:clamp(10px,3vw,14px);
            color:rgba(255,255,255,0.3);transition:all 0.3s ease;
        }
        .tgl.on .tgl-label .lbl-off{color:rgba(255,255,255,0.3);}
        .tgl.on .tgl-label .lbl-on{color:#fff;text-shadow:0 0 10px rgba(255,255,255,0.5);}

        /* Sparkle on toggle */
        .tgl-sparkle{position:absolute;inset:-10px;pointer-events:none;opacity:0;transition:opacity 0.5s;}
        .tgl.on .tgl-sparkle{opacity:1;}
        .sparkle{position:absolute;width:4px;height:4px;background:#fff;border-radius:50%;animation:sparkle 1.5s ease-in-out infinite;}
        .sparkle:nth-child(1){top:0;left:50%;animation-delay:0s;}
        .sparkle:nth-child(2){top:20%;right:0;animation-delay:0.2s;}
        .sparkle:nth-child(3){bottom:20%;right:0;animation-delay:0.4s;}
        .sparkle:nth-child(4){bottom:0;left:50%;animation-delay:0.6s;}
        .sparkle:nth-child(5){bottom:20%;left:0;animation-delay:0.8s;}
        .sparkle:nth-child(6){top:20%;left:0;animation-delay:1s;}
        @keyframes sparkle{0%,100%{opacity:0;transform:scale(0);}50%{opacity:1;transform:scale(1.5);}}

        /* Step 2 */
        .tt{font-family:var(--pf);font-size:clamp(1.4rem,4vw,2.2rem);text-align:center;color:#fff;max-width:22rem;white-space:pre-line;line-height:1.3;padding:0 1rem;}
        .tg{display:grid;grid-template-columns:repeat(3,1fr);gap:clamp(0.5rem,2vw,0.75rem);padding:clamp(0.6rem,2vw,1rem);background:rgba(255,255,255,0.05);backdrop-filter:blur(12px);border-radius:1.5rem;border:1px solid rgba(255,255,255,0.1);}
        .tc{width:clamp(70px,18vw,80px);height:clamp(70px,18vw,80px);background:rgba(255,255,255,0.1);border-radius:1rem;border:none;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.3s;color:#fff;font-size:2.5rem;outline:none;position:relative;overflow:hidden;}
        @media(min-width:640px){.tc{width:75px;height:75px;font-size:3rem;}}
        @media(min-width:768px){.tc{width:80px;height:80px;}}
        .tc:hover{background:rgba(255,255,255,0.2);transform:scale(1.05);box-shadow:0 0 20px rgba(255,255,255,0.1);}
        .tc:active{transform:scale(0.95);}
        .tc .ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,0.4);transform:scale(0);animation:rippleEffect 0.6s ease-out;pointer-events:none;}
        @keyframes rippleEffect{to{transform:scale(4);opacity:0;}}
        .cx{font-weight:900;font-size:2.8rem;background:linear-gradient(135deg,#fff,#ec4899);-webkit-background-clip:text;-webkit-text-fill-color:transparent;filter:drop-shadow(0 0 12px rgba(236,72,153,0.8));animation:xPopIn 0.4s cubic-bezier(0.175,0.885,0.32,1.275);}
        .co{font-weight:900;font-size:2.8rem;background:linear-gradient(135deg,#ec4899,#ef4444);-webkit-background-clip:text;-webkit-text-fill-color:transparent;filter:drop-shadow(0 0 12px rgba(239,68,68,0.8));animation:oPopIn 0.4s cubic-bezier(0.175,0.885,0.32,1.275);}
        @keyframes xPopIn{0%{transform:scale(0) rotate(-180deg);opacity:0;}100%{transform:scale(1) rotate(0deg);opacity:1;}}
        @keyframes oPopIn{0%{transform:scale(0) rotate(180deg);opacity:0;}100%{transform:scale(1) rotate(0deg);opacity:1;}}
        .ch{color:var(--red);filter:drop-shadow(0 0 15px rgba(239,68,68,0.9));animation:ha 0.6s cubic-bezier(0.175,0.885,0.32,1.275);}
        @keyframes ha{0%{transform:scale(0);}50%{transform:scale(1.3);}100%{transform:scale(1);}}

        /* Click ripple effect */
        .click-ripple{position:fixed;pointer-events:none;z-index:9999;}
        .click-ripple .ring{position:absolute;border-radius:50%;border:2px solid rgba(236,72,153,0.6);transform:translate(-50%,-50%) scale(0);animation:ringExpand 0.6s ease-out forwards;}
        .click-ripple .spark{position:absolute;width:4px;height:4px;border-radius:50%;transform:translate(-50%,-50%);animation:sparkFly 0.5s ease-out forwards;}
        @keyframes ringExpand{to{transform:translate(-50%,-50%) scale(1);opacity:0;}}
        @keyframes sparkFly{to{opacity:0;transform:translate(var(--tx),var(--ty)) scale(0);}}

        /* Step 3 */
        .mw{position:relative;width:min(100%,400px);aspect-ratio:2/1;display:flex;flex-direction:column;align-items:center;justify-content:flex-end;overflow:hidden;}
        .msv{position:absolute;top:0;width:100%;height:100%;}
        .mc{z-index:10;display:flex;flex-direction:column;align-items:center;padding-bottom:1rem;}
        .mh{width:3.5rem;height:3.5rem;color:var(--red);fill:var(--red);margin-bottom:0.5rem;animation:pulse 2s ease-in-out infinite;}
        @media(min-width:640px){.mh{width:4rem;height:4rem;}}
        .mv{font-size:clamp(2.5rem,8vw,3.75rem);font-weight:900;color:#fff;font-family:monospace;letter-spacing:-0.05em;}
        .mp{color:rgba(244,63,94,0.7);font-size:clamp(1.2rem,4vw,1.875rem);}
        .ml{font-family:var(--pf);font-style:italic;font-size:clamp(0.9rem,2.5vw,1.25rem);color:rgba(255,255,255,0.6);letter-spacing:0.15em;margin-top:0.5rem;}
        .pt{width:100%;height:6px;background:rgba(255,255,255,0.1);border-radius:9999px;overflow:hidden;border:1px solid rgba(255,255,255,0.05);}
        .pf{height:100%;background:linear-gradient(to right,var(--red),var(--pink));border-radius:9999px;width:0%;transition:width 0.1s linear;}

        /* Step 4 */
        .tw{font-family:var(--pf);font-size:clamp(1.8rem,6vw,4.5rem);text-align:center;line-height:1.3;color:#fff;max-width:90vw;padding:0 1rem;}
        .twc{display:inline-block;width:clamp(3px,0.8vw,6px);height:clamp(1.8rem,5vw,3.5rem);background:var(--red);margin-left:0.4rem;vertical-align:middle;animation:blink 0.8s infinite;}
        @keyframes blink{0%,100%{opacity:1;}50%{opacity:0;}}

        /* Step 5 */
        .fw{display:flex;flex-direction:column;align-items:center;gap:clamp(0.8rem,2vw,1.5rem);text-align:center;max-width:min(500px,90vw);padding:1rem;}
        .fn{font-family:var(--pf);font-size:clamp(2.5rem,10vw,5.5rem);color:var(--red);text-shadow:0 0 40px rgba(239,68,68,0.5);animation:pulse 2s ease-in-out infinite;}
        .fs{font-family:var(--pf);font-size:clamp(1rem,3vw,1.5rem);color:rgba(255,255,255,0.7);font-style:italic;}
        .fm{font-size:clamp(0.85rem,2.5vw,1.1rem);color:rgba(255,255,255,0.5);line-height:1.8;}
        .fht{font-size:clamp(2rem,5vw,3rem);animation:pulse 1.5s ease-in-out infinite;}
        .fbtn{margin-top:1rem;padding:clamp(0.6rem,2vw,0.8rem) clamp(1.5rem,4vw,2rem);border-radius:9999px;border:1px solid rgba(239,68,68,0.3);background:rgba(239,68,68,0.1);color:#fff;font-family:var(--pf);font-size:clamp(0.85rem,2vw,1rem);cursor:pointer;transition:all 0.3s;backdrop-filter:blur(10px);}
        .fbtn:hover{background:rgba(239,68,68,0.3);transform:scale(1.05);}
        .fbtn:active{transform:scale(0.95);}

        /* Gallery - Marquee Style */
        #gallery{position:fixed;inset:0;background:var(--bg);display:none;overflow:hidden;}
        #galleryFloaters{position:absolute;inset:0;overflow:hidden;pointer-events:none;z-index:0;}
        .gallery-wrap{position:relative;z-index:1;width:100%;height:100%;display:flex;flex-direction:column;justify-content:center;gap:clamp(1rem,3vw,2rem);padding:clamp(1rem,3vw,2rem) 0;}
        .gallery-title{font-family:var(--pf);font-size:clamp(1.5rem,5vw,3rem);text-align:center;color:#fff;text-shadow:0 0 30px rgba(239,68,68,0.5);margin-bottom:1rem;}
        .marquee-row{display:flex;width:100%;overflow:hidden;mask-image:linear-gradient(to right,transparent 0%,black 10%,black 90%,transparent 100%);-webkit-mask-image:linear-gradient(to right,transparent 0%,black 10%,black 90%,transparent 100%);}
        .marquee-row.reverse .marquee-track{animation-direction:reverse;}
        .marquee-track{display:flex;gap:clamp(0.8rem,2vw,1.5rem);animation:scrollMarquee 20s linear infinite;width:max-content;}
        .marquee-row:nth-child(2) .marquee-track{animation-duration:25s;}
        .marquee-row:nth-child(3) .marquee-track{animation-duration:18s;}
        @keyframes scrollMarquee{0%{transform:translateX(0);}100%{transform:translateX(-50%);}}
        .gallery-card{flex-shrink:0;width:clamp(120px,25vw,200px);height:clamp(120px,25vw,200px);border-radius:1rem;overflow:hidden;cursor:pointer;transition:all 0.3s;border:2px solid rgba(255,255,255,0.1);position:relative;}
        .gallery-card:hover{transform:scale(1.08);border-color:rgba(239,68,68,0.5);box-shadow:0 0 30px rgba(239,68,68,0.3);}
        .gallery-card img{width:100%;height:100%;object-fit:cover;}
        .gallery-card .fallback{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:3rem;}
        .gallery-back{position:absolute;top:clamp(1rem,3vw,2rem);left:clamp(1rem,3vw,2rem);z-index:10;padding:0.6rem 1.2rem;border-radius:9999px;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.1);backdrop-filter:blur(10px);color:#fff;font-size:0.85rem;cursor:pointer;transition:all 0.3s;}
        .gallery-back:hover{background:rgba(255,255,255,0.2);}

        /* Popup */
        .vw{position:absolute;inset:0;z-index:20;pointer-events:none;display:flex;align-items:center;justify-content:center;padding:clamp(16px,5vw,72px);}
        .sc{position:absolute;inset:0;z-index:10;pointer-events:none;opacity:0;transition:opacity 500ms;background:rgba(0,0,0,0.6);backdrop-filter:blur(8px);}
        .sc.on{opacity:1;pointer-events:all;cursor:pointer;}
        .vf{height:100%;aspect-ratio:1;display:flex;border-radius:var(--r);max-width:90vw;max-height:90vh;}
        .el{position:absolute;inset:0;margin:auto;z-index:30;border-radius:var(--r);overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,.35);width:100%;height:100%;opacity:0;transition:all 300ms ease;}
        .rl{position:absolute;top:50%;transform:translateY(-50%);color:#fff;font-size:clamp(1.5rem,5vw,3rem);opacity:0;transition:all 500ms ease-out;z-index:40;pointer-events:none;text-shadow:0 0 20px rgba(255,105,180,0.5);font-family:var(--pf);}
        .rl.show{opacity:1;transform:translateY(-50%) translate(0,0);}
        .rll{left:5%;transform:translateY(-50%) translateX(-20px);}
        .rlr{right:5%;transform:translateY(-50%) translateX(20px);}
        @media(max-width:640px){.rll{left:0;width:100%;text-align:center;transform:translateY(-80px);}.rll.show{transform:translateY(-80px);} .rlr{right:auto;left:0;width:100%;text-align:center;top:auto;bottom:15%;transform:translateY(20px);}.rlr.show{transform:translateY(0);}}
        body.lk{position:fixed!important;top:0;left:0;width:100%!important;height:100%!important;overflow:hidden!important;touch-action:none!important;}

        /* Audio btn */
        #audiobtn{position:fixed;top:clamp(0.8rem,2vw,1rem);right:clamp(0.8rem,2vw,1rem);z-index:100;width:clamp(36px,9vw,42px);height:clamp(36px,9vw,42px);border-radius:50%;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.1);backdrop-filter:blur(10px);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.3s;color:#fff;font-size:clamp(0.9rem,2.5vw,1.2rem);}
        #audiobtn:hover{background:rgba(239,68,68,0.3);}

        /* Smooth scroll touch */
        @media(hover:none)and(pointer:coarse){
            .tc:active{background:rgba(255,255,255,0.25);}
            .fbtn:active{background:rgba(239,68,68,0.4);}
        }

        @keyframes popFloat{
            0%{opacity:0;transform:translateY(100%) rotate(0deg);}
            10%{opacity:0.3;}
            90%{opacity:0.3;}
            100%{opacity:0;transform:translateY(-100vh) rotate(360deg);}
        }
    </style>
</head>
<body>
    <button id="audiobtn" onclick="toggleAudio()">&#128266;</button>
    <audio id="bgm" loop preload="auto"><source src="/audio.mp3" type="audio/mpeg"></audio>

    <div id="flow">
        <div class="bg-r"></div>
        <div class="bg-c"></div>
        <div class="crn cr-tl"></div>
        <div class="crn cr-br"></div>
        <div id="floaters"></div>

        <!-- Step 1 -->
        <div id="s1" class="step" style="display:flex;flex-direction:column;align-items:center;justify-content:center;position:relative;z-index:10;width:100%;padding:1rem;">
            <div id="lcard" class="love-card">
                <svg id="hico" class="heart-ico" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <div style="text-align:center;width:100%;">
                    <span id="ltxt" class="love-txt">Love mode</span>
                    <div style="display:flex;justify-content:center;">
                        <button id="lbtn" class="tgl">
                            <div class="tgl-knob">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:#ef4444;">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </div>
                            <div class="tgl-label">
                                <span class="lbl-off">OFF</span>
                                <span class="lbl-on">ON</span>
                            </div>
                            <div class="tgl-sparkle">
                                <div class="sparkle"></div><div class="sparkle"></div><div class="sparkle"></div>
                                <div class="sparkle"></div><div class="sparkle"></div><div class="sparkle"></div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2 -->
        <div id="s2" class="step hidden" style="flex-direction:column;align-items:center;gap:clamp(1rem,3vw,2rem);position:relative;z-index:10;width:100%;padding:1rem;">
            <h2 id="tttmsg" class="tt">Lets play a little game, {{ $valentine->name }}!</h2>
            <div class="tg">
                @for ($i = 0; $i < 9; $i++)
                    <button class="tc" data-i="{{ $i }}"><span id="c{{ $i }}"></span></button>
                @endfor
            </div>
            <h2 id="tttres" class="tt hidden"></h2>
        </div>

        <!-- Step 3 -->
        <div id="s3" class="step hidden" style="flex-direction:column;align-items:center;gap:clamp(1.5rem,4vw,3rem);width:100%;max-width:32rem;padding:0 clamp(0.5rem,3vw,1.5rem);position:relative;z-index:10;">
            <h2 class="tt" style="font-size:clamp(1.2rem,3.5vw,1.8rem);">Seberapa besar aku sayang kamu, {{ $valentine->name }}?</h2>
            <div class="mw">
                <svg viewBox="0 0 200 100" class="msv">
                    <path d="M 10,100 A 90,90 0 0 1 190,100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="12" stroke-linecap="round"/>
                    <path id="marc" d="M 10,100 A 90,90 0 0 1 190,100" fill="none" stroke="url(#lg)" stroke-width="12" stroke-linecap="round" stroke-dasharray="282.74" stroke-dashoffset="282.74"/>
                    <defs><linearGradient id="lg" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#ef4444"/><stop offset="100%" stop-color="#ec4899"/></linearGradient></defs>
                </svg>
                <div class="mc">
                    <svg class="mh" viewBox="0 0 24 24" fill="currentColor"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    <div class="mv"><span id="lpct">0</span><span class="mp">%</span></div>
                    <span class="ml">Love Intensity</span>
                </div>
            </div>
            <div class="pt"><div id="pfill" class="pf"></div></div>
        </div>

        <!-- Step 4 -->
        <div id="s4" class="step hidden" style="align-items:center;justify-content:center;padding:1rem;position:relative;z-index:10;width:100%;">
            <h1 class="tw"><span id="twd"></span><span id="twc" class="twc"></span></h1>
        </div>

        <!-- Step 5 -->
        <div id="s5" class="step hidden" style="align-items:center;justify-content:center;padding:1rem;position:relative;z-index:10;width:100%;">
            <div class="fw">
                <div class="fht">&#10084;&#65039;</div>
                <div class="fn">{{ $valentine->name }}</div>
                <div class="fs">{{ $valentine->birth_date ? $valentine->birth_date->diffInYears(now()) . ' tahun penuh cinta' : '' }}</div>
                <div class="fm">
                    @if($valentine->birth_date)
                        Lahir tanggal <b>{{ $valentine->birth_date->format('d F Y') }}</b><br>
                    @endif
                    @if($valentine->message)
                        {!! nl2br(e($valentine->message)) !!}
                    @else
                        Ga ada yang bisa gantiin kamu, {{ $valentine->name }}.<br><br>
                        Setiap hari bersamamu itu spesial buat aku.<br>
                        Kamu itu special, always.
                    @endif
                </div>
                <div style="font-family:var(--pf);font-size:clamp(1rem,2.5vw,1.3rem);color:var(--red);margin-top:0.5rem;">Forever yours &#10084;&#65039;</div>
                <button class="fbtn" onclick="showGallery()">Lihat Galeri Foto &#10084;&#65039;</button>
            </div>
        </div>
    </div>

    <!-- Gallery -->
    <div id="gallery">
        <div id="galleryFloaters"></div>
        <button class="gallery-back" onclick="closeGallery()">&larr; Kembali</button>
        <div class="gallery-wrap">
            <div class="gallery-title">My Beautiful Girl &#10084;&#65039;</div>
            <div id="galleryRows"></div>
        </div>
        <div id="viewer" class="vw">
            <div id="scrim" class="sc"></div>
            <div id="vframe" class="vf"></div>
        </div>
    </div>

    <script>
    (function(){
        var step=1,loveOn=false,board=[null,null,null,null,null,null,null,null,null],uTurn=true,winner=null,lovePct=0;
        var audio=document.getElementById('bgm'),audioBtn=document.getElementById('audiobtn'),audioPlaying=false;
        var colors=['#e74c3c','#e91e63','#9b59b6','#8e44ad','#3498db','#2980b9','#1abc9c','#16a085','#2ecc71','#27ae60','#f39c12','#e67e22','#d35400','#c0392b','#e84393'];

        // Audio
        window.toggleAudio=function(){
            if(audioPlaying){audio.pause();audioBtn.innerHTML='&#128266;';audioPlaying=false;}
            else{audio.play();audioBtn.innerHTML='&#128264;';audioPlaying=true;}
        };
        audio.play().then(function(){audioPlaying=true;audioBtn.innerHTML='&#128264;';}).catch(function(){});

        // Floating items - hearts + sparkles + stars
        (function(){
            var c=document.getElementById('floaters');if(!c)return;
            var items=[
                '<svg viewBox="0 0 24 24" fill="currentColor" width="VAR" height="VAR"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
                '<svg viewBox="0 0 24 24" fill="currentColor" width="VAR" height="VAR"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>',
                '<svg viewBox="0 0 24 24" fill="currentColor" width="VAR" height="VAR"><circle cx="12" cy="12" r="3"/><path d="M12 2v4m0 12v4m10-10h-4M6 12H2m15.07-7.07l-2.83 2.83M9.76 14.24l-2.83 2.83m0-10.14l2.83 2.83m4.48 4.48l2.83 2.83"/></svg>',
                '<svg viewBox="0 0 24 24" fill="currentColor" width="VAR" height="VAR"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>'
            ];
            var cnt=window.innerWidth<600?15:25;
            for(var i=0;i<cnt;i++){
                var el=document.createElement('div');
                el.className='floater';
                var sz=Math.floor(12+Math.random()*16);
                var svg=items[Math.floor(Math.random()*items.length)].replace(/VAR/g,sz);
                el.innerHTML=svg;
                el.style.left=Math.random()*100+'%';
                el.style.animationDuration=(12+Math.random()*18)+'s';
                el.style.animationDelay=(-Math.random()*20)+'s';
                el.style.setProperty('--rot',(Math.random()*360)+'deg');
                el.style.setProperty('--s',(0.4+Math.random()*0.6));
                c.appendChild(el);
            }
        })();

        function showS(n){
            for(var i=1;i<=5;i++){var el=document.getElementById('s'+i);if(el){el.style.display=i===n?'flex':'none';el.classList.remove('hidden','out');}}
            step=n;if(n===3)startMeter();if(n===4)startTW();
        }
        function nextS(n){var cur=document.getElementById('s'+step);if(cur){cur.classList.add('out');setTimeout(function(){showS(n);},400);}}

        // Step 1
        document.getElementById('lbtn').addEventListener('click',function(){
            loveOn=!loveOn;
            var btn=document.getElementById('lbtn'),card=document.getElementById('lcard'),ico=document.getElementById('hico'),txt=document.getElementById('ltxt');
            if(loveOn){
                btn.classList.add('on');card.classList.add('on');ico.classList.add('on');txt.classList.add('on');
                setTimeout(function(){if(loveOn)nextS(2);},3000);
            }else{
                btn.classList.remove('on');card.classList.remove('on');ico.classList.remove('on');txt.classList.remove('on');
            }
        });

        // Step 2
        var LINES=[[0,1,2],[3,4,5],[6,7,8],[0,3,6],[1,4,7],[2,5,8],[0,4,8],[2,4,6]];
        function chkWin(b){for(var i=0;i<LINES.length;i++){var a=LINES[i][0],cl=LINES[i][1],d=LINES[i][2];if(b[a]&&b[a]===b[cl]&&b[a]===b[d])return b[a];}return b.indexOf(null)===-1?'draw':null;}
        var cells=document.querySelectorAll('.tc');
        for(var i=0;i<cells.length;i++){cells[i].addEventListener('click',function(e){
            var idx=parseInt(this.getAttribute('data-i'));if(board[idx]||winner||!uTurn)return;
            createRipple(e,this);
            board[idx]='X';renderC(idx,'X');var r=chkWin(board);if(r){winner=r;endGame(r);return;}uTurn=false;setTimeout(aiMove,600);
        });}
        function aiMove(){var empty=[];for(var i=0;i<9;i++)if(!board[i])empty.push(i);if(!empty.length)return;var nc=[];for(var i=0;i<empty.length;i++)if(empty[i]!==4)nc.push(empty[i]);var idx=nc.length?nc[Math.floor(Math.random()*nc.length)]:4;board[idx]='O';renderC(idx,'O');var r=chkWin(board);if(r){winner=r;endGame(r);}else uTurn=true;}
        function renderC(i,p){var el=document.getElementById('c'+i);if(!el)return;if(p==='X')el.innerHTML='<span class="cx">\u2715</span>';else el.innerHTML='<span class="co">\u25CB</span>';}
        function createRipple(e,el){
            var rect=el.getBoundingClientRect();
            var x=e.clientX-rect.left;var y=e.clientY-rect.top;
            var ripple=document.createElement('div');ripple.className='ripple';
            ripple.style.cssText='left:'+x+'px;top:'+y+'px;width:20px;height:20px;margin-left:-10px;margin-top:-10px;';
            el.appendChild(ripple);
            setTimeout(function(){ripple.remove();},600);
        }
        function endGame(r){
            var msg=document.getElementById('tttmsg'),res=document.getElementById('tttres');
            if(r==='X'){
                msg.textContent='Kamu menang, {{ $valentine->name }}!';res.classList.remove('hidden');res.style.display='block';res.textContent='Tapi hatiku tetap buat kamu';
                for(var i=0;i<9;i++){if(board[i]==='X'){(function(ii){var el=document.getElementById('c'+ii);if(el)setTimeout(function(){el.innerHTML='<span class="ch">\u2764\uFE0F</span>';},ii*150);})(i);}}
                setTimeout(function(){nextS(3);},3500);
            }else{                msg.textContent=r==='draw'?'Seri! Coba lagi yaa \u2764\uFE0F':'Hampir! Sekali lagi, {{ $valentine->name }}...';setTimeout(function(){board=[null,null,null,null,null,null,null,null,null];winner=null;uTurn=true;for(var i=0;i<9;i++){var el=document.getElementById('c'+i);if(el)el.innerHTML='';}                msg.textContent="Lets play a little game, {{ $valentine->name }}!";},1500);}
        }

        // Step 3
        function startMeter(){lovePct=0;var circ=282.74;var iv=setInterval(function(){lovePct++;var arc=document.getElementById('marc'),pct=document.getElementById('lpct'),bar=document.getElementById('pfill');if(arc)arc.setAttribute('stroke-dashoffset',circ-(lovePct/100)*circ);if(pct)pct.textContent=lovePct;if(bar)bar.style.width=lovePct+'%';if(lovePct>=100){clearInterval(iv);setTimeout(function(){nextS(4);},1500);}},40);}

        // Step 4
        var ucapan='{{ addslashes($valentine->ucapan ?? "Love you, ' . addslashes($valentine->name) . '!") }}';
        var twLines=[ucapan,'Ga ada yang bisa gantiin kamu.','You mean everything to me.'];
        var twLineIdx=0,twD='',twDel=false;
        function startTW(){twD='';twDel=false;twLineIdx=0;typeLoop();}
        function typeLoop(){
            var el=document.getElementById('twd');if(!el)return;var cur=twLines[twLineIdx];
            if(!twDel&&twD!==cur){twD=cur.substring(0,twD.length+1);el.textContent=twD;setTimeout(typeLoop,80);}
            else if(!twDel&&twD===cur){if(twLineIdx<twLines.length-1)setTimeout(function(){twDel=true;typeLoop();},2000);else setTimeout(function(){nextS(5);},2500);}
            else if(twDel&&twD!==''){twD=cur.substring(0,twD.length-1);el.textContent=twD;setTimeout(typeLoop,40);}
            else if(twDel&&twD===''){twDel=false;twLineIdx++;if(twLineIdx<twLines.length)setTimeout(typeLoop,300);}
        }

        // Gallery
        var fEl=null;
        var photos=@json($valentine->photos ?? []);
        window.showGallery=function(){document.getElementById('flow').style.display='none';document.getElementById('gallery').style.display='block';initGalleryFloaters();buildGalleryRows();};
        window.closeGallery=function(){document.getElementById('gallery').style.display='none';document.getElementById('flow').style.display='flex';};
        function initGalleryFloaters(){var c=document.getElementById('galleryFloaters');if(!c)return;c.innerHTML='';var items=['<svg viewBox="0 0 24 24" fill="currentColor" width="VAR" height="VAR"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>','<svg viewBox="0 0 24 24" fill="currentColor" width="VAR" height="VAR"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>','<svg viewBox="0 0 24 24" fill="currentColor" width="VAR" height="VAR"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>'];var cnt=window.innerWidth<600?15:25;for(var i=0;i<cnt;i++){var el=document.createElement('div');el.className='floater';var sz=Math.floor(12+Math.random()*16);var svg=items[Math.floor(Math.random()*items.length)].replace(/VAR/g,sz);el.innerHTML=svg;el.style.left=Math.random()*100+'%';el.style.animationDuration=(12+Math.random()*18)+'s';el.style.animationDelay=(-Math.random()*20)+'s';c.appendChild(el);}}
        function buildGalleryRows(){
            var container=document.getElementById('galleryRows');if(!container)return;container.innerHTML='';
            var displayPhotos=photos.length>0?photos:colors;
            var rows=3;
            for(var r=0;r<rows;r++){
                var row=document.createElement('div');row.className='marquee-row'+(r%2===1?' reverse':'');
                var track=document.createElement('div');track.className='marquee-track';
                var totalItems=window.innerWidth<600?10:14;
                for(var i=0;i<totalItems;i++){
                    var card=document.createElement('div');card.className='gallery-card';
                    var photoIdx=i%displayPhotos.length;
                    if(photos.length>0){
                        var img=document.createElement('img');img.src='/storage/'+displayPhotos[photoIdx];img.loading='lazy';
                        card.appendChild(img);
                    }else{
                        var fb=document.createElement('div');fb.className='fallback';
                        fb.style.background='linear-gradient(135deg,'+colors[photoIdx]+','+colors[(photoIdx+3)%colors.length]+')';
                        fb.innerHTML='<svg viewBox="0 0 24 24" fill="rgba(255,255,255,0.3)" width="40" height="40"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>';
                        card.appendChild(fb);
                    }
                    (function(idx){card.addEventListener('click',function(){openPopup(idx);});})(photoIdx);
                    track.appendChild(card);
                }
                row.appendChild(track);container.appendChild(row);
            }
        }
        function openPopup(idx){
            if(fEl)return;fEl=true;document.body.classList.add('lk');
            var frame=document.getElementById('vframe'),scrim=document.getElementById('scrim');
            var ov=document.createElement('div');ov.className='el';
            ov.style.cssText='width:100%;height:100%;position:relative;overflow:hidden;border-radius:var(--r);background:radial-gradient(circle at center,rgba(239,68,68,0.15) 0%,transparent 70%);';
            var floatContainer=document.createElement('div');
            floatContainer.style.cssText='position:absolute;inset:0;overflow:hidden;pointer-events:none;z-index:1;';
            var floaterSVGs=['<svg viewBox="0 0 24 24" fill="currentColor" width="VAR" height="VAR"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>','<svg viewBox="0 0 24 24" fill="currentColor" width="VAR" height="VAR"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>'];
            for(var i=0;i<12;i++){
                var fEl2=document.createElement('div');
                fEl2.style.cssText='position:absolute;animation:popFloat 8s linear infinite;opacity:0.2;color:rgba(255,255,255,0.5);';
                var sz=Math.floor(8+Math.random()*12);
                fEl2.innerHTML=floaterSVGs[i%2].replace(/VAR/g,sz);
                fEl2.style.left=Math.random()*100+'%';
                fEl2.style.animationDelay=(-Math.random()*8)+'s';
                floatContainer.appendChild(fEl2);
            }
            ov.appendChild(floatContainer);
            var ph=document.createElement('div');
            ph.style.cssText='position:relative;z-index:2;width:100%;height:100%;display:flex;align-items:center;justify-content:center;background-size:contain;background-repeat:no-repeat;background-position:center;border-radius:var(--r);';
            if(photos.length>0){
                ph.style.backgroundImage='url(/storage/'+photos[idx%photos.length]+')';
            }else{
                ph.style.background='linear-gradient(135deg,'+colors[idx%colors.length]+','+colors[(idx+3)%colors.length]+')';
                ph.innerHTML='<svg viewBox="0 0 24 24" fill="rgba(255,255,255,0.4)" width="60" height="60"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>';
            }
            ov.appendChild(ph);frame.appendChild(ov);scrim.classList.add('on');
            requestAnimationFrame(function(){ov.style.opacity='1';});
            var v=document.getElementById('viewer');
            var romanticTexts=[
                'You\'re my everything',
                'Forever yours',
                'My heart is yours',
                'You mean the world to me',
                'Always & forever',
                'My one and only',
                'You make me complete',
                'Cinta sejati',
                'My sunshine',
                'You\'re beautiful',
                'I love you most',
                'My happy place',
                'You\'re perfect',
                'My soulmate',
                'You\'re my home'
            ];
            var randomText=romanticTexts[Math.floor(Math.random()*romanticTexts.length)];
            var lL=document.createElement('div');lL.className='rl rll';lL.textContent=randomText;
            var lR=document.createElement('div');lR.className='rl rlr';lR.textContent='{{ $valentine->name }}';
            v.appendChild(lL);v.appendChild(lR);
            setTimeout(function(){lL.classList.add('show');lR.classList.add('show');},300);
        }
        function closePopup(){
            var ov=document.querySelector('.el'),scrim=document.getElementById('scrim'),v=document.getElementById('viewer');
            if(ov){ov.style.opacity='0';setTimeout(function(){ov.remove();},300);}
            scrim.classList.remove('on');
            var lbls=v.querySelectorAll('.rl');for(var i=0;i<lbls.length;i++){lbls[i].classList.remove('show');(function(l){setTimeout(function(){l.remove();},500);})(lbls[i]);}
            document.body.classList.remove('lk');fEl=null;
        }
        document.getElementById('scrim').addEventListener('click',closePopup);
        document.addEventListener('keydown',function(e){if(e.key==='Escape'){if(fEl)closePopup();else if(document.getElementById('gallery').style.display==='block')closeGallery();}});

        // Global click sparkle effect
        document.addEventListener('click',function(e){
            if(e.target.closest('#audiobtn')||e.target.closest('.tc')||e.target.closest('.fbtn')||e.target.closest('.ii')||e.target.closest('button')||e.target.closest('a'))return;
            var container=document.createElement('div');container.className='click-ripple';container.style.left=e.clientX+'px';container.style.top=e.clientY+'px';
            var ring=document.createElement('div');ring.className='ring';ring.style.width='60px';ring.style.height='60px';container.appendChild(ring);
            var sparkColors=['#ef4444','#ec4899','#f472b6','#fb923c','#fbbf24','#a78bfa','#34d399'];
            for(var i=0;i<8;i++){
                var spark=document.createElement('div');spark.className='spark';
                var angle=(i/8)*Math.PI*2;var dist=30+Math.random()*40;
                var tx=Math.cos(angle)*dist;var ty=Math.sin(angle)*dist;
                spark.style.cssText='--tx:'+tx+'px;--ty:'+ty+'px;background:'+sparkColors[i%sparkColors.length]+';';
                container.appendChild(spark);
            }
            document.body.appendChild(container);
            setTimeout(function(){container.remove();},700);
        });
        showS(1);
    })();
    </script>
</body>
</html>
