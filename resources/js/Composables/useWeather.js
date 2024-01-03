import { computed, ref, watch, toRefs } from "vue";

export default function useWeather(now, fiveDay) {
    const nowRefs = toRefs(now);
    const infoNow = computed(() => nowRefs.main.value);
    const iconNow = computed(
        () =>
            `https://openweathermap.org/img/wn/${nowRefs.weather.value[0].icon}@2x.png`,
    );
    const descNow = computed(() =>
        nowRefs.weather.value[0].description.toUpperCase(),
    );

    const fiveDays = computed(() => {
        const uniqueDates = new Set();
        return fiveDay
            .filter((day) => {
                const date = new Date(day.dt_txt).toLocaleDateString("en-US", {
                    month: "short",
                    day: "numeric",
                });
                if (!uniqueDates.has(date)) {
                    uniqueDates.add(date);
                    return true;
                }
                return false;
            })
            .slice(1);
    });

    const dtToShort = (dt) =>
        new Date(dt).toLocaleDateString("en-US", {
            weekday: "short",
            month: "short",
            day: "numeric",
        });

    const dt2LocalT = () => {
        const offsetSeconds = now.timezone;
        let nowUtc = Date.now() + new Date().getTimezoneOffset() * 60000;
        let date = new Date(nowUtc + offsetSeconds * 1000);
        return date.toLocaleTimeString(undefined, {
            hour: "2-digit",
            minute: "2-digit",
            hour12: true,
        });
    };

    const toFahrenheit = (Ctemp) => ((Ctemp * 9) / 5 + 32).toFixed(0);

    const showInF = ref(false);
    const shownTemp = (temp) =>
        showInF.value ? `${toFahrenheit(temp)}°F` : `${temp}°C`;

    const timeNow = ref(dt2LocalT());

    watch(showInF, shownTemp);

    let gradients = {
        "https://openweathermap.org/img/wn/01d@2x.png":
            "linear-gradient(to bottom right, #c0caf8, #e0e0e0, #fcd9b6)",
        "https://openweathermap.org/img/wn/02d@2x.png":
            "linear-gradient(to bottom right, #c0caf8, #ffffff, #c0caf8)",
        "https://openweathermap.org/img/wn/03d@2x.png":
            "linear-gradient(to bottom right, #c0caf8, #ffffff, #c0caf8)",
        "https://openweathermap.org/img/wn/04d@2x.png":
            "linear-gradient(to bottom right, #e0e0e0, #ffffff, #e0e0e0)",
        "https://openweathermap.org/img/wn/05d@2x.png":
            "linear-gradient(to bottom right, #c0caf8, #e0e0e0, #fcd9b6)",
        "https://openweathermap.org/img/wn/06d@2x.png":
            "linear-gradient(to bottom right, #c0caf8, #e0e0e0, #fcd9b6)",
        "https://openweathermap.org/img/wn/07d@2x.png":
            "linear-gradient(to bottom right, #c0caf8, #e0e0e0, #fcd9b6)",
        "https://openweathermap.org/img/wn/08d@2x.png":
            "linear-gradient(to bottom right, #c0caf8, #e0e0e0, #fcd9b6)",
        "https://openweathermap.org/img/wn/09d@2x.png":
            "linear-gradient(to bottom right, #7f9cf5, #93c5fd, #e0e0e0)",
        "https://openweathermap.org/img/wn/10d@2x.png":
            "linear-gradient(to bottom right, #7f9cf5, #93c5fd, #e0e0e0)",
        "https://openweathermap.org/img/wn/11d@2x.png":
            "linear-gradient(to bottom right, #a5b4c3, #6b46c1, #a5b4c3)",
        "https://openweathermap.org/img/wn/13d@2x.png":
            "linear-gradient(to bottom right, #c0caf8, #ffffff, #e0e0e0)",
        "https://openweathermap.org/img/wn/50d@2x.png":
            "linear-gradient(to bottom right, #e0e0e0, #fde68a, #a5b4c3)",
        "https://openweathermap.org/img/wn/01n@2x.png":
            "linear-gradient(to bottom right, #374151, #1e3a8a, #000000)",
        "https://openweathermap.org/img/wn/02n@2x.png":
            "linear-gradient(to bottom right, #374151, #a5b4c3, #1e3a8a)",
        "https://openweathermap.org/img/wn/03n@2x.png":
            "linear-gradient(to bottom right, #374151, #a5b4c3, #1e3a8a)",
        "https://openweathermap.org/img/wn/04n@2x.png":
            "linear-gradient(to bottom right, #374151, #a5b4c3, #374151)",
        "https://openweathermap.org/img/wn/05n@2x.png":
            "linear-gradient(to bottom right, #c0caf8, #e0e0e0, #fcd9b6)",
        "https://openweathermap.org/img/wn/06n@2x.png":
            "linear-gradient(to bottom right, #c0caf8, #e0e0e0, #fcd9b6)",
        "https://openweathermap.org/img/wn/07n@2x.png":
            "linear-gradient(to bottom right, #c0caf8, #e0e0e0, #fcd9b6)",
        "https://openweathermap.org/img/wn/08n@2x.png":
            "linear-gradient(to bottom right, #c0caf8, #e0e0e0, #fcd9b6)",
        "https://openweathermap.org/img/wn/09n@2x.png":
            "linear-gradient(to bottom right, #374151, #1e3a8a, #374151)",
        "https://openweathermap.org/img/wn/10n@2x.png":
            "linear-gradient(to bottom right, #374151, #1e3a8a, #374151)",
        "https://openweathermap.org/img/wn/11n@2x.png":
            "linear-gradient(to bottom right, #374151, #4c1d95, #000000)",
        "https://openweathermap.org/img/wn/13n@2x.png":
            "linear-gradient(to bottom right, #374151, #a5b4c3, #374151)",
        "https://openweathermap.org/img/wn/50n@2x.png":
            "linear-gradient(to bottom right, #4b5563, #a5b4c3, #374151)",
    };

    const currentGradient = computed(() => gradients[iconNow.value]);

    return {
        infoNow,
        iconNow,
        descNow,
        fiveDays,
        dtToShort,
        dt2LocalT,
        toFahrenheit,
        showInF,
        shownTemp,
        timeNow,
        currentGradient,
    };
}
