import React, { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';

import '../css/app.css';

const initialForm = {
    checkin: '',
    checkout: '',
    paxes: '2',
    hotel: '',
};

function getErrorMessage(response, fallback) {
    if (response?.errors) {
        return Object.values(response.errors).flat().join(' ');
    }

    return response?.message || fallback;
}

function AvailabilityApp() {
    const [hotels, setHotels] = useState([]);
    const [form, setForm] = useState(initialForm);
    const [results, setResults] = useState([]);
    const [hotelsLoading, setHotelsLoading] = useState(true);
    const [searching, setSearching] = useState(false);
    const [hotelsError, setHotelsError] = useState('');
    const [searchError, setSearchError] = useState('');

    useEffect(() => {
        const loadHotels = async () => {
            try {
                const response = await fetch('/api/v1/hotels');
                const data = await response.json();

                if (!response.ok) {
                    throw new Error(getErrorMessage(data, 'Unable to load hotels.'));
                }

                setHotels(data);
            } catch (error) {
                setHotelsError(error.message || 'Unable to load hotels.');
            } finally {
                setHotelsLoading(false);
            }
        };

        loadHotels();
    }, []);

    const updateField = (event) => {
        setForm((current) => ({ ...current, [event.target.name]: event.target.value }));
    };

    const searchAvailability = async (event) => {
        event.preventDefault();
        setSearching(true);
        setSearchError('');
        setResults([]);

        const payload = {
            checkin: form.checkin,
            checkout: form.checkout,
            paxes: Number(form.paxes),
        };

        if (form.hotel) {
            payload.hotel = form.hotel;
        }

        try {
            const response = await fetch('/api/v1/availability', {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload),
            });
            const data = await response.json();

            if (!response.ok) {
                throw new Error(getErrorMessage(data, 'Unable to check availability.'));
            }

            setResults(data);
        } catch (error) {
            setSearchError(error.message || 'Unable to check availability.');
        } finally {
            setSearching(false);
        }
    };

    return (
        <main className="min-h-screen bg-[#f7f8f5] px-5 py-8 text-slate-900 sm:px-8 sm:py-12">
            <div className="mx-auto max-w-5xl">
                <header className="mb-8 max-w-2xl">
                    <p className="mb-3 text-xs font-bold uppercase tracking-[0.24em] text-teal-700">Stayfinder</p>
                    <h1 className="text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl">Find a room for your next stay.</h1>
                    <p className="mt-4 text-base leading-7 text-slate-600">Search current hotel inventory by dates and guests. Choose a hotel or leave the search open to see every available option.</p>
                </header>

                <section className="rounded-3xl border border-slate-200 bg-white p-5 shadow-[0_20px_60px_-35px_rgba(15,23,42,0.45)] sm:p-8" aria-labelledby="search-title">
                    <div className="mb-6 flex items-center justify-between gap-4">
                        <div>
                            <h2 id="search-title" className="text-lg font-semibold text-slate-950">Search availability</h2>
                            <p className="mt-1 text-sm text-slate-500">Tell us when you are travelling.</p>
                        </div>
                        <span className="hidden rounded-full bg-teal-50 px-3 py-1 text-xs font-medium text-teal-700 sm:inline-flex">Live inventory</span>
                    </div>

                    <form className="grid gap-5 md:grid-cols-2" onSubmit={searchAvailability}>
                        <label className="block">
                            <span className="mb-2 block text-sm font-medium text-slate-700">Check-in</span>
                            <input className="field" type="date" name="checkin" value={form.checkin} onChange={updateField} required />
                        </label>
                        <label className="block">
                            <span className="mb-2 block text-sm font-medium text-slate-700">Check-out</span>
                            <input className="field" type="date" name="checkout" value={form.checkout} onChange={updateField} required />
                        </label>
                        <label className="block">
                            <span className="mb-2 block text-sm font-medium text-slate-700">Guests</span>
                            <input className="field" type="number" name="paxes" min="1" value={form.paxes} onChange={updateField} required />
                        </label>
                        <label className="block">
                            <span className="mb-2 block text-sm font-medium text-slate-700">Hotel <span className="font-normal text-slate-400">(optional)</span></span>
                            <select className="field" name="hotel" value={form.hotel} onChange={updateField} disabled={hotelsLoading}>
                                <option value="">All hotels</option>
                                {hotels.map((hotel) => <option key={hotel.code} value={hotel.code}>{hotel.name}</option>)}
                            </select>
                        </label>
                        <div className="md:col-span-2">
                            <button className="w-full rounded-xl bg-teal-700 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-teal-800 disabled:cursor-not-allowed disabled:opacity-60" type="submit" disabled={searching}>
                                {searching ? 'Searching availability...' : 'Search rooms'}
                            </button>
                        </div>
                    </form>

                    {hotelsLoading && <p className="mt-4 text-sm text-slate-500" role="status">Loading hotels...</p>}
                    {hotelsError && <p className="mt-4 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">{hotelsError}</p>}
                    {searchError && <p className="mt-4 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">{searchError}</p>}
                </section>

                <section className="mt-10" aria-labelledby="results-title">
                    <div className="mb-4 flex items-end justify-between gap-4">
                        <div>
                            <p className="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Results</p>
                            <h2 id="results-title" className="mt-1 text-2xl font-semibold text-slate-950">Available rooms</h2>
                        </div>
                        {results.length > 0 && <span className="text-sm text-slate-500">{results.length} {results.length === 1 ? 'option' : 'options'}</span>}
                    </div>

                    {searching && <div className="rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-10 text-center text-sm text-slate-500" role="status">Checking the latest availability...</div>}
                    {!searching && results.length === 0 && !searchError && <div className="rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-10 text-center text-sm text-slate-500">Your available rooms will appear here.</div>}
                    {!searching && results.length > 0 && <div className="grid gap-4 md:grid-cols-2">{results.map((result) => <article className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm" key={`${result.hotel.code}-${result.roomType.code}`}><div className="flex items-start justify-between gap-4"><div><h3 className="font-semibold text-slate-950">{result.hotel.name}</h3><p className="mt-1 text-sm text-slate-500">{result.roomType.name}</p></div><p className="text-right text-lg font-semibold text-teal-700">{Number(result.price).toFixed(2)}<span className="ml-1 text-xs font-medium text-slate-400">per night</span></p></div><p className="mt-5 border-t border-slate-100 pt-3 text-xs font-medium uppercase tracking-wider text-slate-400">{result.hotel.code} · {result.roomType.code}</p></article>)}</div>}
                </section>
            </div>
        </main>
    );
}

createRoot(document.getElementById('app')).render(<AvailabilityApp />);
