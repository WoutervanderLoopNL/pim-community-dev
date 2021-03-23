import {renderHook} from '@testing-library/react-hooks';
import useInfiniteScroll from '@src/webhook/scroll/hooks/useInfiniteScroll';
import {fireEvent} from '@testing-library/dom';

beforeEach(() => {
    document.body.innerHTML = `
    <div>
        <div id='content'></div>
    </div>
    `;
});

test('The first page is fetched on mount', async () => {
    const ref = {
        current: document.getElementById('content'),
    };

    const loadNextPage = jest.fn().mockImplementationOnce(() => {
        return Promise.resolve(null);
    });
    const {waitForNextUpdate, unmount} = renderHook(() => useInfiniteScroll(loadNextPage, ref));

    await waitForNextUpdate();
    expect(loadNextPage).toHaveBeenCalledTimes(1);

    unmount();
});

test('The second page is fetched, with the first response as parameter', async () => {
    const ref = {
        current: document.getElementById('content'),
    };

    const loadNextPage = jest
        .fn()
        .mockImplementationOnce(() => {
            return Promise.resolve({
                results: ['foo', 'bar'],
                search_after: 'bar',
            });
        })
        .mockImplementationOnce(prev => {
            expect(prev).toEqual({
                results: ['foo', 'bar'],
                search_after: 'bar',
            });
            return Promise.resolve(null);
        });

    const {waitForNextUpdate, unmount} = renderHook(() => useInfiniteScroll(loadNextPage, ref));

    await waitForNextUpdate();
    expect(loadNextPage).toHaveBeenCalledTimes(1);

    // Since we are in jest, the scroll is not computed correctly.
    // Meaning is, since the scroll height is stuck at 0, it will try anyway.
    fireEvent.scroll(document.body, {target: {scrollY: 100}});

    await waitForNextUpdate();
    expect(loadNextPage).toHaveBeenCalledTimes(2);

    unmount();
});
